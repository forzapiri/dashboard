/**
 *  This file is part of Dashboard.
 *
 *  Dashboard is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  Dashboard is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with Dashboard.  If not, see <http://www.gnu.org/licenses/>.
 *  
 *  @license http://www.gnu.org/licenses/gpl.txt
 *  @copyright Copyright 2007-2009 Norex Core Web Development
 *  @author See CREDITS file
 *
 */

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