jQuery(document).ready(function($) {
    var currentTermId = ajax_filter_params.default_term_id || 0; // Use the default term ID

    function loadPosts(term_id, paged) {
        $.ajax({
            url: ajax_filter_params.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_posts',
                term_id: term_id,
                paged: paged,
            },
            success: function(response) {
                $('#locations-container').html(response);
                currentTermId = term_id;
                updatePaginationLinks(paged);
                updateActiveTerm(term_id); // Update active term on successful load
            }
        });
    }

    function updatePaginationLinks(activePage) {
        $('.page-link').removeClass('active');
        $('.page-link[data-page="' + activePage + '"]').addClass('active');
    }

    function updateActiveTerm(term_id) {
        $('#taxonomy-terms a').removeClass('active');
        $('#taxonomy-terms a[data-term-id="' + term_id + '"]').addClass('active');
    }

    $('#taxonomy-terms a').on('click', function(e) {
        e.preventDefault();
        var term_id = $(this).data('term-id');
        loadPosts(term_id, 1); // Load the first page when a new term is selected
    });

    $(document).on('click', '.page-link', function(e) {
        e.preventDefault();
        var paged = $(this).data('page');
        loadPosts(currentTermId, paged);
    });

    // Initialize by loading posts for the default or current term with the first page
    loadPosts(currentTermId, 1);
});
