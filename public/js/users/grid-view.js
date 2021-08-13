$(document).ready(function() {
    $('#button-view-grid').on('click', function() {
        if ($('#view-grid').hasClass('d-none')) {
            $('#button-view-list').attr('class', 'btn btn-link text-dark')
            $('#button-view-grid').attr('class', 'btn btn-dark')
            $('#view-grid').removeClass('d-none')
            $('#view-list').addClass('d-none')
        }
    })
    $('#button-view-list').on('click', function() {
        if ($('#view-list').hasClass('d-none')) {
            $('#button-view-grid').attr('class', 'btn btn-link text-dark')
            $('#button-view-list').attr('class', 'btn btn-dark')
            $('#view-grid').addClass('d-none')
            $('#view-list').removeClass('d-none')
        }
    })

    $('#view-grid-search').on('keyup', function() {
        var query = $('#view-grid-search').val();
        var column_name = $('#view-grid-sort').val();
        var sort_type = 'asc';
        //var page = $('#hidden_page').val();
        showViewGrid(sort_type, column_name, query);
    });

    $('#view-grid-sort').on('change', function() {
        var query = $('#view-grid-search').val();
        var column_name = $('#view-grid-sort').val();
        var sort_type = 'asc';
        //var page = $('#hidden_page').val();
        showViewGrid(sort_type, column_name, query);
    });
})

function showViewGrid(sort_type = null, sort_by = null, query = null) {
    $.ajax({
        url: "/users/grid-view?sortby=" + sort_by + "&sorttype=" + sort_type + "&query=" + query,
        success: function(data) {
            console.log(data)
            $('#view-grid-users').html('');
            $('#view-grid-users').html(data);
        },
        error: function(error) {
            console.log(error)
        }
    })
}

function viewGridPageItem(curentpageno) {
    activePageId = $('#activepage').val()
    if (!$('#page' + activePageId).hasClass('active')) {
        $('#pageno' + activePageId).removeClass('active')
        $('#pageno' + curentpageno).addClass('active')
        $('#activepage').val(curentpageno)
        $('#page' + activePageId).addClass('d-none')
        $('#page' + curentpageno).removeClass('d-none')
    }
}

function viewGridPageNextPage(nbUsers) {
    visiblepageid = $('#activepage').val()
    if (visiblepageid < nbUsers) {
        curentpageno = parseInt(visiblepageid) + 1
        $('#pageno' + visiblepageid).removeClass('active')
        $('#pageno' + curentpageno).addClass('active')
        $('#activepage').val(curentpageno)
        $('#page' + visiblepageid).addClass('d-none')
        $('#page' + curentpageno).removeClass('d-none')
    }
}

function viewGridPagePreviousPage() {
    visiblepageid = $('#activepage').val()
    if (visiblepageid != 1) {
        curentpageno = parseInt(visiblepageid) - 1
        $('#pageno' + visiblepageid).removeClass('active')
        $('#pageno' + curentpageno).addClass('active')
        $('#activepage').val(curentpageno)
        $('#page' + visiblepageid).addClass('d-none')
        $('#page' + curentpageno).removeClass('d-none')
    }
}