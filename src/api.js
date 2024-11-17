
function getID(id) {
    return document.getElementById(id);
}

function getValue(id) {
    return getID(id).value;
}

function addClick(id, voids) {
    getID(id).addEventListener('click', () => {
        voids();
    })
}

function goTo(link) {
    window.location.href = link;
}

function fundoVM(id) {
    var corantiga = getID(id).style.backgroundColor;
    getID(id).style.transition = '0.3s all linear';
    getID(id).style.backgroundColor = 'rgb(200,100,100)';
    setTimeout(() => {
        getID(id).style.transition = '0.9s all linear';
        getID(id).style.backgroundColor = corantiga;
    }, 1000);
}

function bordaVM(id) {
    getID(id).style.transition = '0.3s all linear';
    var corantiga = getID(id).style.border;
    getID(id).style.border = '2px solid red';
    setTimeout(() => {
        getID(id).style.border = corantiga;
    }, 3000);
}


//não funciona
function CallPHP(link) {
    var s = 'vazio'
    fetch(link)
        .then(response => {
            return response.text()
        })
        .then(data => {
            s = data
        })

    setTimeout(() => {
        return s
    }, 1000);
}






