$('#exampleModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget)
    // const nombre = button.data('name')
    // const id = button.data('id')
    const modal = $(this)
    // modal.find('.pokemon_borrar').text(nombre)
    // modal.find('.borrar').attr("href","borrar.php?id="+id);
})