function updatePermissions() {
    var user_id = $('#user_id').html();
    elements = ['accounts', 'appointments', 'communications', 'contact_data', 'contacts', 'contacts_companies', 'contacts_field', 'contacts_persons', 'custom_field', 'email_accounts', 'fax_accounts', 'groups', 'imports', 'logs', 'notes', 'sip_accounts', 'sms_accounts', 'users', 'users_permissions', 'shortcodes'];
    codes = ['show', 'create', 'update', 'delete'];
    elements.forEach(element => {
        codes.forEach(code => {
            //console.log('#permissions-'+element+'-'+code)
            console.log($('#permissions-'+element+'-'+code).val())
        });
    });
}