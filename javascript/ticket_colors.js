const tags = document.querySelectorAll('.tag');
var index = 0;
const tagColors = [ "#FFD700", // gold 
                    "#00CED1", // dark turquoise 
                    "#7B68EE", // medium slate blue 
                    "#FF69B4", // hot pink 
                    "#FFA07A", // light salmon 
                    "#8B008B", // dark magenta 
                    "#00FA9A", // medium spring green 
                    "#1E90FF"  // dodger blue
                ];
const tagColorMap = new Map();
tags.forEach(tag => {
    var colorAssigned = tagColorMap.get(tag.textContent);
    if (colorAssigned != undefined)
        tag.style.backgroundColor = colorAssigned;
    else {
        tag.style.backgroundColor = tagColors[index];
        tagColorMap.set(tag.textContent, tagColors[index]);
        index = (index + 1) % tagColors.length;
    }
});

const statuses = document.querySelectorAll('.status');
statuses.forEach(status => {
    if (status.textContent.trim() == "Open")
        status.style.backgroundColor = "#FF6347";
    else if (status.textContent.trim() == "Closed")
        status.style.backgroundColor = "#32CD32";
});