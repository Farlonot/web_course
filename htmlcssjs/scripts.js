const colors = ['white', 'red', 'orange', 'yellow', 'green', 'aqua', 'blue', 'purple'];
const baseTransitionTime = 0.5
const transitionTimes = Array(colors.length-1).fill(baseTransitionTime);
const objArray = [];
let isFirstRun = true;
let isErasing = false; 

function timer(){
    onmessage = function(event){
        setTimeout(() => {
            postMessage(event.data);
          }, event.data);
    }
}

class Obj {
    div;
    #worker;
    #colorIndex;
    constructor(index, useLocalStorage) {
        let newDiv = document.createElement('div');
        newDiv.id = 'box_' + index;        
        newDiv.style.zIndex = 1;
        newDiv.onmouseover = handleMouseOver;
        newDiv.onmouseleave = handleMouseOut;
        newDiv.onclick = handleMouseClick;

        this.div = newDiv
        this.#colorIndex = (isInLocalStorage([this.div.id]) && useLocalStorage) ?
        Number(localStorage.getItem(this.div.id)) : 0;
        this.#worker = undefined;
        this.#updateStyle();
        this.#save();
    }

    #save(){
        localStorage.setItem(this.div.id, this.#colorIndex);
    }

    #updateStyle(newColor, transitionTime){
        let color = (newColor !== undefined) ? newColor : colors[Number(this.#colorIndex)];
        let transition = (transitionTime !== undefined) ? transitionTime : transitionTimes[(this.#colorIndex)%transitionTimes.length];
        this.div.style.transition = `background-color ${transition}s ease`
        this.div.style.backgroundColor = color;
    }

    #startUpdate(){
        this.#updateStyle(colors[Number(this.#colorIndex)+1]);
    }
    #endUpdate(){
        this.#colorIndex++;
        this.#updateStyle();
        this.#save();
    }
    #breakUpdate(){
        this.#updateStyle(undefined, 0);
    }

    startChangingColor(){
        if (this.#colorIndex >= colors.length-1)
            return;
  
        //this.#worker = new Worker('timer.js');
        this.#worker = new Worker(URL.createObjectURL(new Blob(["("+timer.toString()+")()"], {type: 'text/javascript'})));
        this.#worker.onmessage = () => {
                this.#endUpdate();
                if (this.#worker !== undefined && this.#colorIndex <= colors.length-1){
                    this.startChangingColor();
                }
            }
        this.#worker.postMessage(transitionTimes[this.#colorIndex%7]*1000);
        this.#startUpdate();
    }

    breakChangingColor(){
        this.#breakUpdate();
        if (this.#worker !== undefined){
            this.#worker.terminate();
        }
    }

    resetChanging(){
        this.#colorIndex = 0;
        this.#updateStyle(undefined, 0.2);
        this.#save();
    }
}
//
function handleMouseOver(event) {
    if (!isErasing){
        objArray[getIndex(event)].startChangingColor();
    }
}
function handleMouseOut(event) {
    objArray[getIndex(event)].breakChangingColor();
}
function handleMouseClick(event) {
    if (isErasing){
        objArray[getIndex(event)].resetChanging();
    }
    
}
function getIndex(event){
    return event.target.id.split('_')[1];
}


//transition time update functions
function setAllColorsTime(){
    for(i = 0; i < colors.length - 1; i++){
        setColorTime('change_' + i);
    }
}
function setColorTime(id){
    const target = document.getElementById(id);
    if (Number(target.value) <= 0){
        target.value = 0
    }
    setTransitionTime(id.split('_')[1], target.value);
}
function setTransitionTime(index, value){
    transitionTimes[index] = value;
    //console.log('old: ', transitionTimes, '\nupdated', transitionTimes);
}


//addition funcs
function isInLocalStorage(checkedArray){
    for(i = 0; i < checkedArray.length; i++){
        if(localStorage.getItem(checkedArray[i]) === null){
            return false;
        }
    }
    return true;
}


//
function changeContainerSize(){

    if(isInLocalStorage(['number_rows','number_columns']) && isFirstRun){
        document.getElementById('number_rows').value = localStorage.getItem('number_rows');
        document.getElementById('number_columns').value = localStorage.getItem('number_columns');
    }
    
    let numberRows = document.getElementById('number_rows').value;
    let numberColumns = document.getElementById('number_columns').value;

    numberRows = (numberRows > 0) ? numberRows : 1;
    numberColumns = (numberColumns > 0) ? numberColumns : 1;
    
    document.getElementById('number_rows').value = numberRows;
    document.getElementById('number_columns').value = numberColumns;
    
    localStorage.setItem('number_rows', numberRows);
    localStorage.setItem('number_columns', numberColumns);

    const changer = document.getElementsByClassName("game-window");
    changer[0].style.gridTemplateColumns = `repeat(${numberColumns}, 1fr)`;
    changer[0].style.gridTemplateRows = `repeat(${numberRows}, 1fr)`;

    return [numberRows, numberColumns];
}

//
function createBoxArray(){
    const size = changeContainerSize().reduce( (a,b) => a * b, 1 );
    const gameWindow = document.getElementById('game-window');
    gameWindow.innerHTML = '';
    objArray.length = 0;
    for(let i = 0; i < size; i++){
        objArray.push(new Obj(i, isFirstRun));
        gameWindow.appendChild(objArray[i].div);
    }
    if(isFirstRun){
        isFirstRun = false;
    }
}

//on erase checkbox click handler
function checkBoxUpdate(isChecked){
    isErasing = isChecked;
    document.body.style.cursor = (isErasing ? 'url(./image/cursor/smalleraser.png),' : '')+ 'auto';
}

//on create button click handler
function createButton(event){
    if (!isErasing){
        createBoxArray();   
        event.blur();        
    }
    else{
        eraseBgColor('create_button'); 
    }
}
///////////////////////////////////////////////////////////////
///////////////////////additional tricks///////////////////////
///////////////////////////////////////////////////////////////

function setBgGradient(){
// :c no luck no luck
    for (let i = 0; i < transitionTimes.length; i++){
        str = Array.from({ length: 11 }, (_, index) => (index % 2 === 0 ? colors[i] : colors[i+1])).join(",");
        let target = document.getElementById(`change_${i}`);
        target = target.parentNode;
        target.style.backgroundImage = `linear-gradient(90deg,${str})`;
        target.style.animation = 'frames 20s linear infinite';
        target.style.backgroundSize = '1100% 100%';
        target.title = `Set transition time from ${colors[i]} to ${colors[i+1]}`;
    }
}

function eraseBgColor(id){
     if (!isErasing){
        return;
    }
    const target = document.getElementById(id);
    target.style.border= 'none';
    target.style.background= 'none';
}

function eraseFromHtmlById(id){
    if (!isErasing){
        return;
    }
    eraseFromHtml(document.getElementById(id));
}

function eraseSky(){
    eraseFromHtmlById('sky');
}

function eraseRainbow(id){
    if (!isErasing){
        return;
    }
    eraseFromHtml(document.getElementsByClassName(`${colors[Number(id.split('_')[1])+1]}`)[0]);
    
}

function eraseFromHtml(target){
    if (target !== undefined && target !== null){
        target.parentNode.removeChild(target);
    }
}
