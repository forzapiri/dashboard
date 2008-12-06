sfHover = function() {
	if (document.getElementById("navUl").getElementsByTagName("LI"))
	{
		var sfEls = document.getElementById("navUl").getElementsByTagName("LI");
		for (var i=0; i<sfEls.length; i++)
		{
			if (sfEls[i].className != "menuDivider")
			{
				sfEls[i].onmouseover=function() {
					this.className = "sfhover";
				}
				sfEls[i].onmouseout=function() {
					this.className = "";
				}
			}
		}
	}
}
if (window.attachEvent) window.attachEvent("onload", sfHover);