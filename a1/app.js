const requestURL = 'http://jslessons/a1/ajax.getrecipeid2.php'

let f = fetch (requestURL, {
        method: 'GET',
    }).then (response => {
        return response.text()
    }).then( str => {
        console.log (str)
    })

    console.log (f)



// const requestURL = 'http://jslessons/a1/ajax.getrecipeid2.php'

// function createCORSRequest() {
//     var xhr = new XMLHttpRequest();
//     if ("withCredentials" in xhr) {
//         xhr.open("get", requestURL, true);
//     } else if (typeof XDomainRequest != "undefined") {
//         xhr = new XDomainRequest();
//         xhr.open(method, url);
//     } else {
//         xhr = null;
//     }
//     return xhr;
// }

// function getpage() {
//     var request = createCORSRequest();
//       if (request) {
//         request.onload = function() {
//             console.log(this.responseText);
//         };
//         request.send();
//       }
//     }

//     getpage()