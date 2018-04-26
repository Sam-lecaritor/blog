function Confirmation(slug, title) {

    var r = confirm("voulez vous vraiment supprimer l'article " + title + " ? ");
    if (r == true) {
        window.location.replace("/blog/admin/article/" + slug + "/delete");
    }
}


function confirmDeleteComment(id, pseudo, page, index){
    var r = confirm("voulez vous vraiment supprimer le commentaire de " + pseudo + " ? ");
    if (r == true) {
        window.location.replace("/blog/admin/comments/delete/" + id + "/" + page + "/"+ index);
    }

}

function confirmCheckComment(id, pseudo, page, index) {
    var r = confirm("voulez vous vraiment approuver le commentaire de " + pseudo + " ? ");
    if (r == true) {
        window.location.replace("/blog/admin/comments/checked/" + id + "/" + page + "/" + index);
    }

}