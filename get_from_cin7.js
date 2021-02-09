//import { Dropbox } from 'dropbox';

const dbx = new Dropbox.Dropbox({
    accessToken: 'st6uRYoqPikAAAAAAAAAAR5VdZ8VGudINxhFFWiOa0jDBl-pmcd4BH_rHzUAxQbl',
    fetch
})

function Dropupload() {
    let url = new URL("https://cdnjs.cloudflare.com/ajax/libs/dropbox.js/7.1.0/Dropbox-sdk.js");
    let params = new URLSearchParams(url.search);
    params.delete('fetch');
    var fileInput = document.getElementById('test');
    var file = fileInput;
    if (/*typeof fileInput === "undefined"*/ fileInput == null) {
        console.log('File is clearly undefined');
    }
    dbx.filesUpload({path: '/' + file.name, contents: file})
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