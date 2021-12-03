// Config Ajax
function setAjaxHeader() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });
}

// Confirm Delete handle
$('.handleDelete').on('click', function(e){
    var $this = $(this);
    $this.prop("disabled", true);
    $.confirm({
        title: false,
        content: "You want DELETE this",
        columnClass:
            "default",
        buttons: {
            confirm: {
                text: "Yes",
                action: function() {
                    $this.parents("form").submit();
                }
            },
            cancel: {
                text: "No",
                action: function() {
                    $this.prop("disabled", false);
                }
            }
        }
    });
});