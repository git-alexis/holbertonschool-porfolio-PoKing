function afficherCarte1Board() {
    let indexNumberCard1Board = numbersboard1select.selectedIndex;
    let numberCard1Board = numbersboard1select.options[indexNumberCard1Board].value;
    
    let indexSuitsCard1Board = suitsboard1select.selectedIndex;
    let suitsCard1Board = suitsboard1select.options[indexSuitsCard1Board].value;
    
    if (isNaN(numberCard1Board)) {
        numberCard1Board = numberCard1Board.charAt(0);
    }
    
    document.getElementById("boardcards1").value = numberCard1Board+suitsCard1Board.charAt(0).toLowerCase();
    return false;
}

function afficherCarte2Board() {
    let indexNumberCard2Board = numbersboard2select.selectedIndex;
    let numberCard2Board = numbersboard2select.options[indexNumberCard2Board].value;
    
    let indexSuitsCard2Board = suitsboard2select.selectedIndex;
    let suitsCard2Board = suitsboard2select.options[indexSuitsCard2Board].value;
    
    if (isNaN(numberCard2Board)) {
        numberCard2Board = numberCard2Board.charAt(0);
    }
    
    document.getElementById("boardcards2").value = numberCard2Board+suitsCard2Board.charAt(0).toLowerCase();
    return false;
}

function afficherCarte3Board() {
    let indexNumberCard3Board = numbersboard3select.selectedIndex;
    let numberCard3Board = numbersboard3select.options[indexNumberCard3Board].value;
    
    let indexSuitsCard3Board = suitsboard3select.selectedIndex;
    let suitsCard3Board = suitsboard3select.options[indexSuitsCard3Board].value;
    
    if (isNaN(numberCard3Board)) {
        numberCard3Board = numberCard3Board.charAt(0);
    }
    
    document.getElementById("boardcards3").value = numberCard3Board+suitsCard3Board.charAt(0).toLowerCase();
    return false;
}

function afficherCarte1Hole() {
    let indexNumberCard1Hole = numbershole1select.selectedIndex;
    let numberCard1Hole = numbershole1select.options[indexNumberCard1Hole].value;
    
    let indexSuitsCard1Hole = suitshole1select.selectedIndex;
    let suitsCard1Hole = suitshole1select.options[indexSuitsCard1Hole].value;
    
    if (isNaN(numberCard1Hole)) {
        numberCard1Hole = numberCard1Hole.charAt(0);
    }
    
    document.getElementById("holecards1").value = numberCard1Hole+suitsCard1Hole.charAt(0).toLowerCase();
    return false;
}

function afficherCarte2Hole() {
    let indexNumberCard2Hole = numbershole2select.selectedIndex;
    let numberCard2Hole = numbershole2select.options[indexNumberCard2Hole].value;
    
    let indexSuitsCard2Hole = suitshole2select.selectedIndex;
    let suitsCard2Hole = suitshole2select.options[indexSuitsCard2Hole].value;
    
    if (isNaN(numberCard2Hole)) {
        numberCard2Hole = numberCard2Hole.charAt(0);
    }
    
    document.getElementById("holecards2").value = numberCard2Hole+suitsCard2Hole.charAt(0).toLowerCase();
    return false;
}
