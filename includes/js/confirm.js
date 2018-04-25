function Confirmation(slug, title) {

    var r = confirm("voulez vous vraiment supprimer l'article " + title + " ? ");
    if (r == true) {
        window.location.replace("/blog/admin/article/" + slug + "/delete");
    }
}
