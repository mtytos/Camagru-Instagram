(function () {

    var width = 320;
    var height = 0;

    var streaming = false;

    var video = null;
    var canvas = null;
    var photo = null;
    var startbutton = null;

    function startup() {
        video = document.getElementById('video');
        canvas = document.getElementById('canvas');
        photo = document.getElementById('photo');
        startbutton = document.getElementById('startbutton');

        navigator.mediaDevices.getUserMedia({video: true, audio: false})
            .then(function (stream) {
                video.srcObject = stream;
                video.play();
            })
            .catch(function (err) {
                console.log("An error occurred: " + err);
            });

        video.addEventListener('canplay', function (ev) {
            if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);

                if (isNaN(height)) {
                    height = width / (4 / 3);
                }

                video.setAttribute('width', width);
                video.setAttribute('height', height);
                canvas.setAttribute('width', width);
                canvas.setAttribute('height', height);
                streaming = true;
            }
        }, false);

        startbutton.addEventListener('click', function (ev) {
            takepicture();

            // var piclink = "https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/one.png";
            var piclink = encodeURIComponent(canvas.toDataURL("image/png"));
            //var piclink = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAASwAAACWCAYAAABkW7XSAAAEaUlEQVR4Xu3UAQkAMAwDwdW/k5rcYC4ergrCpWR29x5HgACBgMAYrEBLIhIg8AUMlkcgQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEDBYfoAAgYyAwcpUJSgBAgbLDxAgkBEwWJmqBCVAwGD5AQIEMgIGK1OVoAQIGCw/QIBARsBgZaoSlAABg+UHCBDICBisTFWCEiBgsPwAAQIZAYOVqUpQAgQMlh8gQCAjYLAyVQlKgIDB8gMECGQEDFamKkEJEHjr+8DkBQk1VgAAAABJRU5ErkJggg==";
            var form = {
                // pic: piclink,
                // username: document.getElementById('username'),
                pic: piclink,
                submit: document.getElementById('btn-submit'),
                messages: document.getElementById('form-messages')
            };

            var request = new XMLHttpRequest();

            request.onload = () => {
                let responseObject = null;

                try {
                    responseObject = JSON.parse(request.responseText);
                } catch (e) {
                    console.error('Could not parse JSON!');
                }

                if (responseObject) {
                    handleResponse(responseObject);
                }
            };

            var requestData = `pic=${form.pic}`;

            request.open('post', '../tmp/picDeliver.php');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.send(requestData);

            function handleResponse(responseObject) {
                if (responseObject.ok) {

                    var picForm = document.createElement('form');
                    picForm.setAttribute('method', 'post');
                    picForm.setAttribute('enctype', 'multipart/form-data');
                    picForm.setAttribute('action', '../core/uploadClass.php');
                    picForm.setAttribute('class', 'picForm');
                    document.getElementById("tempPic").appendChild(picForm);

                    var img = document.createElement('img');
                    var link = responseObject.link;
                    var value = username;
                    img.setAttribute("src", link);
                    img.setAttribute("value", value);
                    document.querySelector('.picForm:last-child').appendChild(img);

                    var btnUpload = document.createElement('button');
                    btnUpload.setAttribute('type', 'submit');
                    btnUpload.setAttribute('name', 'upload');
                    btnUpload.setAttribute('value', link);
                    btnUpload.appendChild(document.createTextNode("Зпостить"));
                    document.querySelector('.picForm:last-child').appendChild(btnUpload);
                } else {
                    var img = document.createElement('img');
                    var link = "https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/spiderman.jpg";
                    var value = username;
                    img.setAttribute("src", link);
                    img.setAttribute("value", value);
                    document.getElementById("tempPic").appendChild(img);
                }
            }

            //
            // var picForm = document.createElement('form');
            // picForm.setAttribute('method', 'post');
            // picForm.setAttribute('enctype', 'multipart/form-data');
            // picForm.setAttribute('action', '../core/uploadClass.php');
            // picForm.setAttribute('class', 'picForm');
            // document.getElementById("tempPic").appendChild(picForm);
            //
            // var img = document.createElement('img');
            // var link = canvas.toDataURL();
            // var value = username;
            // img.setAttribute("src", link);
            // img.setAttribute("value", value);
            // document.querySelector('.picForm:last-child').appendChild(img);
            //
            // var btnUpload = document.createElement('button');
            // btnUpload.setAttribute('type', 'submit');
            // btnUpload.setAttribute('name', 'upload');
            // btnUpload.setAttribute('value', link);
            // btnUpload.appendChild(document.createTextNode("Зпостить"));
            // document.querySelector('.picForm:last-child').appendChild(btnUpload);
            //
            // var btnDownload = document.createElement('button');
            // btnDownload.setAttribute('type', 'submit');
            // btnDownload.setAttribute('name', 'download');
            // btnDownload.setAttribute('value', 'link');
            // btnDownload.appendChild(document.createTextNode("Загрузить"));
            // document.querySelector('.picForm:last-child').appendChild(btnDownload);
            //
            //
            // var link = document.createElement('a');
            // link.innerHTML = 'download image';
            // link.addEventListener('click', function(ev) {
            //     link.href = canvas.toDataURL();
            //     link.download = "mypainting.png";
            // }, false);
            // document.getElementById("try").appendChild(link);
            ev.preventDefault();
        }, false);

        clearphoto();
    }

    // Fill the photo with an indication that none has been
    // captured.

    function clearphoto() {
        var context = canvas.getContext('2d');
        context.fillStyle = "#AAA";
        context.fillRect(0, 0, canvas.width, canvas.height);

        var data = canvas.toDataURL('image/png');
        var picNotFound = "../src/picNotFound.jpg";
        photo.setAttribute('src', data);
    }

    // Capture a photo by fetching the current contents of the video
    // and drawing it into a canvas, then converting that to a PNG
    // format data URL. By drawing it on an offscreen canvas and then
    // drawing that to the screen, we can change its size and/or apply
    // other changes before drawing it.

    function takepicture() {
        var context = canvas.getContext('2d');
        if (width && height) {
            canvas.width = width;
            canvas.height = height;
            context.drawImage(video, 0, 0, width, height);
            var data = canvas.toDataURL('image/png');
            photo.setAttribute('src', data);
        } else {
            clearphoto();
        }
    }

    // Set up our event listener to run the startup process
    // once loading is complete.
    window.addEventListener('load', startup, false);
})();