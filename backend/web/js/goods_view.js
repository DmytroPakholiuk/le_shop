function deleteAttribute(goodsId, attributeId) {
    console.log(goodsId,attributeId)
    $.post(
        'delete-attribute',
        {goodsId: goodsId, attributeId: attributeId},
        function(data, status){
            alert(data.message);
            $('#'+attributeId).parentsUntil('tbody').hide()
        }
    )
}