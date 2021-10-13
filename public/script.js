// changing color of div & adding values to answer array
function answer(blockId) {
    selectedAns = document.getElementById('answer[' + blockId + ']')
    if (selectedAns.style.backgroundColor === 'whitesmoke') {
        // color
        selectedAns.style.backgroundColor = 'green'
        // setting value & disabling other elements for click
        document.getElementById('uInput').setAttribute('value', blockId)
        answers = document.getElementsByClassName('answer')
        for (var i = 0; i < answers.length; i++) {
            answers[i].style.pointerEvents = 'none'
        }
        selectedAns.style.pointerEvents = 'all'
        // state of submit button

        document.getElementById('submit-button').disabled = false
    } else {
        //color
        selectedAns.style.backgroundColor = 'whitesmoke'
        // setting value & disabling other elements for click
        document.getElementById('uInput').setAttribute('value', 0)
        answers = document.getElementsByClassName('answer')
        for (var i = 0; i < answers.length; i++) {
            answers[i].style.pointerEvents = 'all'
        }
        // state of submit button
        document.getElementById('submit-button').disabled = true
    }
}