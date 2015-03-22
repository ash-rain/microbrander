var canvas = $("canvas").hide()[0]
var zoom = 1

$("#image img").load(function(){
	var img = $(this)
	var h = (img.width() / $(canvas).width()) * img.height();
	zoom = $(canvas).width() / img.data("width")
	$(canvas).height(h).show()
	$("#image").hide()
	drawText()
})

$("[name='text']").keyup(drawText)

$("form").submit(function(e) {
	e.preventDefault()
	e.returnValue = false

	var data = canvas.toDataURL()
	var form = $(this)

	$.ajax({
		type: "post",
		url: postUrl,
		data: { 
			data: data,
			imageable_id: productId,
			_method: $("#image").is(".new") ? "POST" : "PATCH",
			_token: $("input[name='_token']").val()
		},
		context: form,
		complete: function() {
			if($("#image").is(".new")) location.reload()
			else {
				this.unbind("submit");
				this.submit()
			}	
		}
	})
	return false
})

function drawText() {
	var text = $("[name='text']").val()
	paper.setup(canvas);
	paper.view.zoom = zoom
	new paper.Raster($("#image img")[0], paper.view.center)
	var t = new paper.PointText(paper.view.center)

	if(drawConfig.rotate)
		t.rotate( drawConfig.rotate )
	t.content = text
	t.style = {
		fontFamily: (drawConfig.font || "sans-serif"),
		fontSize: (drawConfig.font_size || 14),
		fillColor: (drawConfig.fill || "#000000"),
		justification: (drawConfig.align || "left"),
		shadowColor: "rgba(0,0,0,0.2)",
		shadowBlur: 2,
		shadowOffset: new paper.Point(-1)
	}
	
	if(drawConfig.x && drawConfig.y)
		t.translate( new paper.Point(drawConfig.x, drawConfig.y) )
	
	paper.view.draw();
}