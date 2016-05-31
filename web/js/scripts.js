
$( document ).ready(function() {

    $('#newCommentButton').click(function() {
        var _postid = $('#postid').val();
        var _titulo = $('#newCommentTitle').val();
        var _comentario = $('#newCommentBody').val().trim();

        if (_postid == "") {
            $('#errores').html('An error occurred with the post reference');
            return false;
        }
        if (_titulo == "" && _comentario == "") {
            $('#errores').html('The comment precises title and body');
            return false;
        }
        if (_titulo == "") {
            $('#errores').html('The comment precises title');
            return false;
        }
        if (_comentario == "") {
            $('#errores').html('The comment precises body');
            return false;
        }

        if ( (_postid != "") && (_titulo != "") && (_comentario != "") ) {
            $.ajax({
                type: "POST",
                data: {
                    "parentid": _postid,
                    "titulo": _titulo,
                    "comentario": _comentario
                },
                url: "/app_dev.php/newcomment",
                success: function(html) {
                    if (html == 'error: 1') {
                        $('#errores').html('Ha ocurrido un error con la referencia al post');
                    } else if (html == 'error: 2') {
                        $('#errores').html('No se ha podido completar la operacion');
                    } else if (html == 'error: 3') {
                        $('#errores').html('No se ha podido completar la operacion');
                    } else if (html == 'error: 4') {
                        $('#errores').html('No se ha podido completar la operacion');
                    } else if (html == 'error: 5') {
                        $('#errores').html('No se ha podido completar la operacion');
                    } else {
                        $('#listadoComments').html(html);
                    }
                }
            });
        }
        return false;
     });
});

function deleteComment(_commentid) {
    var _postid = $('#postid').val();

    if (_postid == "") {
        $('#errores').html('Ha ocurrido un error con la referencia al post');
        return false;
    }

    if ( (_commentid != "") && (_postid != "") && confirm('Borrar el comentario?') ) {
        $.ajax({
            type: "POST",
            data: {
                "parentid": _postid,
                "postid": _commentid
            },
            url: "/app_dev.php/deletecomment",
            success: function(html) {
                if (html == 'error: 1') {
                    $('#errores').html('Los campos no pueden estar vacios');
                } else if (html == 'error: 2') {
                    $('#errores').html('Ha ocurrido un error con la referencia al post');
                } else if (html == 'error: 3') {
                    $('#errores').html('No se ha podido completar la operacion');
                } else {
                    $('#listadoComments').html(html);
                }
            }
        });
    }
}


