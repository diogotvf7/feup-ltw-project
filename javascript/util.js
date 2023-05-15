export function timeAgo(_date) {
    const date = new Date(_date); 
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);

    if (diff < 60) {
      return 'just now';
    } else if (diff < 3600) {
      const minutes = Math.floor(diff / 60);
      return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
    } else if (diff < 86400) {
      const hours = Math.floor(diff / 3600);
      return `${hours} hour${hours > 1 ? 's' : ''} ago`;
    } else if (diff < 2592000) {
      const days = Math.floor(diff / 86400);
      return `${days} day${days > 1 ? 's' : ''} ago`;
    } else if (diff < 31536000) {
      const months = Math.floor(diff / 2592000);
      return `${months} month${months > 1 ? 's' : ''} ago`;
    } else {
      const years = Math.floor(diff / 31536000);
      return `${years} year${years > 1 ? 's' : ''} ago`;
    }
}

export function limitDisplayLength(string, maxSize) {
    if (string.length > maxSize) 
        return string.substr(0, maxSize - 3) + '...';
    return string;
}

export async function setTagsColor() {
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
            status.style.backgroundColor = "#32CD32";
        else if (status.textContent.trim() == "Closed")
            status.style.backgroundColor = "#FF6347";
        else if (status.textContent.trim() == "In progress")
            status.style.backgroundColor = "#FFD700";
    });
}

export function getParameterByName(parameter) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(parameter);
}