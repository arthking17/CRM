<?php

namespace App\Imports;

use App\Models\Contact;
use App\Models\Contacts_companie;
use App\Models\Contacts_person;
use DateTime;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Naxon\UrlUploadedFile\UrlUploadedFile;
use Throwable;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;

class ContactImport extends DefaultValueBinder implements ToCollection, SkipsEmptyRows, WithCustomValueBinder
{
    use Importable;

    private $rows;
    private $heading;
    private $account_id;
    private $import_id;
    private $column;
    private $skip = 0;
    private $errors = 0;
    private $columnDate = 1;
    private $skipErrors;

    public function __construct($heading = null, $column = null, $account_id = null, $import_id = null, $skipErrors = null)
    {
        $this->heading = $heading;
        $this->column = $column;
        $this->account_id = $account_id;
        $this->import_id = $import_id;
        if ($heading)
            $this->skip = 1;
        $this->skipErrors = $skipErrors;
    }

    public function bindValue(Cell $cell, $value)
    {
        if (strtotime($value)) {
            $time = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($value);
            $cell->setValue($time);
            //if(is_numeric($time))
            //$cell->setValue(date('Y-m-d', $time));
            $this->columnDate = $cell->getColumn();
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function collection(Collection $rows)
    {
        $this->rows = $rows;
        $alphabet   = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
        $key = array_search($this->columnDate, $alphabet);
        try {
            foreach ($this->rows->skip($this->skip) as $row) {
                $row[$key] = date('Y-m-d', $row[$key]);
            }
        } catch (Exception $e) {
        }
    }

    public function get10FirstRows()
    {
        if ($this->heading)
            return $this->rows->take(11);
        else
            return $this->rows->take(10);
    }

    public function getColumnCount()
    {
        return $this->rows->first()->count();
    }

    public function getRowCount()
    {
        return $this->rows->count() - $this->skip;
    }

    public function insertPersonContactInDB()
    {
        try {
            if ($this->column['birthdate']) {
                foreach ($this->rows->skip($this->skip) as $row) {
                    if (is_string($row[$this->column['birthdate']])) {
                        $row[$this->column['birthdate']] = str_replace('/', '-', $row[$this->column['birthdate']]);
                        $time = strtotime($row[$this->column['birthdate']]);
                        $row[$this->column['birthdate']] = date('Y-m-d', $time);
                    }
                }
            }
        } catch (Exception $e) {
            report($e);
        }

        if (!$this->skipErrors)
            Validator::make($this->rows->skip($this->skip)->toArray(), [
                //validate contact
                '*.' . $this->column['source_id'] => 'required|integer|digits_between:0,10',
                '*.' . $this->column['source'] => 'required|string',
                '*.' . $this->column['status'] => 'required|string',
                '*.' . $this->column['language'] => 'nullable|string',
                '*.' . $this->column['country'] => 'nullable|string',
                //validate person contact data
                '*.' . $this->column['first_name'] => 'required|string|max:255',
                '*.' . $this->column['last_name'] => 'required|string|max:255',
                '*.' . $this->column['nickname'] => 'string|nullable|max:255',
                '*.' . $this->column['profile'] => 'required|string',
                '*.' . $this->column['gender'] => 'required|string',
                '*.' . $this->column['birthdate'] => 'date|nullable|min:today',
            ])->validate();

        foreach ($this->rows->skip($this->skip) as $row) {
            try {
                $contact = new Contact();
                $contact->class = 1;
                $contact->source_id = $row[$this->column['source_id']];
                $contact->source = getSourceByName($row[$this->column['source']]);
                $contact->status = getStatusByName($row[$this->column['status']]);
                $contact->creation_date = new DateTime();
                $contact->import_id = $this->import_id;
                $contact->account_id = $this->account_id;
                $contact->save();

                $contact_person = new Contacts_person();
                $contact_person->id = $contact->id;
                $contact_person->profile = getProfileByName($row[$this->column['profile']]);
                $contact_person->first_name = $row[$this->column['first_name']];
                $contact_person->last_name = $row[$this->column['last_name']];
                $contact_person->nickname = $row[$this->column['nickname']];
                if ($row[$this->column['gender']] == 'male')
                    $contact_person->gender = 1;
                if ($row[$this->column['gender']] == 'female')
                    $contact_person->gender = 2;
                if ($this->column['language'])
                    $contact_person->language = strtoupper($row[$this->column['language']]);
                if ($this->column['country'])
                    $contact_person->country = $row[$this->column['country']];
                if ($this->column['birthdate'])
                    $contact_person->birthdate = $row[$this->column['birthdate']];
                $contact_person->save();
            } catch (Throwable $e) {
                if (!$this->skipErrors) {
                    $this->errors = 1;
                    report($e);
                }
                $contact = Contact::find($contact->id);
                if ($contact)
                    $contact->delete();
            }
        }
        return $contact_person;
    }

    public function insertCompanieContactInDB()
    {
        //return $this->column;
        //return $this->rows;
        if (!$this->skipErrors)
            Validator::make($this->rows->skip($this->skip)->toArray(), [
                //validate contact
                '*.' . $this->column['source_id'] => 'required|integer|digits_between:0,10',
                '*.' . $this->column['source'] => 'required|string',
                '*.' . $this->column['status'] => 'required|string',
                '*.' . $this->column['language'] => 'nullable|string',
                '*.' . $this->column['country'] => 'nullable|string',
                //validate companie contact data
                '*.' . $this->column['name'] => 'required|string|max:255',
                '*.' . $this->column['registered_number'] => 'integer|nullable|digits_between:0,128',
                '*.' . $this->column['logo'] => 'nullable|url',
                '*.' . $this->column['activity'] => 'nullable|integer|digits_between:0,10',
            ])->validate();

        //$info = pathinfo($this->rows[2][$this->column['logo']]);
        //return $this->rows[2][$this->column['logo']]->storePublicly('public/images/logo');
        foreach ($this->rows->skip($this->skip) as $row) {
            try {
                $contact = new Contact();
                $contact->class = 2;
                $contact->source_id = $row[$this->column['source_id']];
                $contact->source = getSourceByName($row[$this->column['source']]);
                $contact->status = getStatusByName($row[$this->column['status']]);
                $contact->creation_date = new DateTime();
                $contact->import_id = $this->import_id;
                $contact->account_id = $this->account_id;
                $contact->save();

                $contact_companie = new Contacts_companie();
                $contact_companie->id = $contact->id;
                $contact_companie->class = getCompanieClassByName($row[$this->column['class']]);
                $contact_companie->name = $row[$this->column['name']];
                if ($this->column['registered_number'])
                    $contact_companie->registered_number = $row[$this->column['registered_number']];
                if ($this->column['logo']) {
                    $logo = UrlUploadedFile::createFromUrl($row[$this->column['logo']]);
                    $logo->storePublicly('public/images/logo');
                    $contact_companie->logo = $logo->hashName();
                }
                if ($this->column['language'])
                    $contact_companie->language = $row[$this->column['language']];
                if ($this->column['country'])
                    $contact_companie->country = strtoupper($row[$this->column['country']]);
                if ($this->column['activity'])
                    $contact_companie->activity = $row[$this->column['activity']];
                $contact_companie->save();
            } catch (Throwable $e) {
                if (!$this->skipErrors) {
                    $this->errors = 1;
                    report($e);
                }
                $contact = Contact::find($contact->id);
                if ($contact)
                    $contact->delete();
                Storage::delete('public/images/logo' . $contact_companie->logo);
            }
        }
        return $contact_companie;
    }

    public function containErrors()
    {
        return $this->errors;
    }
}
