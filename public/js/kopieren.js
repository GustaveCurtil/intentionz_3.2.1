
function copy(link, soort) {
        navigator.clipboard.writeText(link).then(() => {
            alert("❀ " + soort + " is gekopieerd ❀");
        }).catch(err => {
            console.error("Failed to copy: ", err);
            alert("Link kopieeren is niet gelukt precies...");
        });
    }
