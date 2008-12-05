function genFlash(filename, width, height, bgcolor, wmode)
{
	var fGhead = new Flash();
	fGhead.setSWF (filename, width, height);
	if (bgcolor)
	{
		fGhead.setParam ('bgcolor', bgcolor);
	}
	if (wmode)
	{
		fGhead.setParam ('wmode', wmode);
	}
	fGhead.display ();
}