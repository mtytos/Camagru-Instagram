// var piclink = "https://raw.githubusercontent.com/mtytos/Hackaton-PhotoLab-TikTok/master/spiderman.jpg";

const form = {
    pic: document.getElementById('pic'),
    submit: document.getElementById('btn-submit'),
    messages: document.getElementById('form-messages')
};

form.submit.addEventListener('click', () => {
    const request = new XMLHttpRequest();

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

    const requestData = `pic=${form.pic.value}`;

    request.open('post', '../tmp/picDownl.php');
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    request.send(requestData);
});

function handleResponse (responseObject) {
    if (responseObject.ok) {
        while (form.messages.firstChild) {
            form.messages.removeChild(form.messages.firstChild);
        }
        responseObject.messages.forEach((message) => {
            const p = document.createElement('p');
            p.textContent = message;
            form.messages.appendChild(p);
        });
        // var img = document.createElement('img');
        // var src = responseObject.link;
        // var value = "username";
        // img.setAttribute("src", src);
        // img.setAttribute("value", value);
        // document.getElementById("lol").appendChild(img);
    }
    else {
        while (form.messages.firstChild) {
            form.messages.removeChild(form.messages.firstChild);
        }

        responseObject.messages.forEach((message) => {
            const p = document.createElement('p');
            p.textContent = message;
            form.messages.appendChild(p);
        });
    }
}