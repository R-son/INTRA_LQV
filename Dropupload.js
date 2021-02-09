function Dropupload() {
    //dbx.filesUpload({path: '/' + file.name, contents: file})
    dbx.filesUpload({ path: '/Images/sky.jpg', contents: file })
    .then(function (response) {
        var results = document.getElementById('results');
        results.appendChild(document.createTextNode('File uploaded!'));
        console.log('MISSION COMPLETE');
    })
    .catch(function (error) {
        console.error(error);
        console.log('BETTER LUCK NEXT TIME');
    });
}