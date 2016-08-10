if (document.getElementById('file-list') !== null) {
    // Get the input and UL list
    var input = document.getElementById('files'),
        list  = document.getElementById('file-list');

    // Empty list for now...
    while (list.hasChildNodes()) {
        list.removeChild(ul.firstChild);
    }

    // For every file...
    for (var x = 0; x < input.files.length; x++) {
        // Add to list
        var li = document.createElement('li');
        li.innerHTML = 'File ' + (x + 1) + ':  ' + input.files[x].name;
        list.append(li);
    }
}
