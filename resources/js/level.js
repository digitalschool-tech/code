import * as Blockly from 'blockly';
import 'blockly/blocks'
import 'blockly/core'

import { translate } from "./translations";
import * as Sq from "./blockly/sq";
import * as Forward from "./blockly/blocks/forward";
import * as Start from "./blockly/blocks/start";
import * as Turn from "./blockly/blocks/turn";

import { javascriptGenerator } from 'blockly/javascript'
import { dropWhile } from 'lodash';
Blockly.setLocale(Sq);

const playerDown = document.getElementById("down");
const playerUp = document.getElementById("up");
const playerLeft = document.getElementById("left");
const playerRight = document.getElementById("right");
const playerSprites = [playerUp, playerRight, playerDown, playerLeft];
const goalImg = document.getElementById("goal");
const grass_1 = document.getElementById("grass_1");
const grass_2 = document.getElementById("grass_2");
const grass_3 = document.getElementById("grass_3");
const grasses = [grass_1, grass_2, grass_3];
const obstacles = [];
const main = document.getElementById("main");
const blocks = JSON.parse(main.getAttribute("data-blocks"))
const modalLost = document.getElementById('modal-lost');
const modalWon = document.getElementById('modal-won');
let failed = false;
let obstacleCords = [];
let obstacleCordsString = [];

for(let i = 1; i < 7; i++){
    obstacles.push(document.getElementById("rock1_" + i ))
}

addBlock(Blockly, Forward)
addBlock(Blockly, Turn)
addBlock(Blockly, Start)

var toolbox = {
	"kind": "flyoutToolbox",
	"contents": [
		{
			"kind": "block",
			"type": "forward"
		},
		{
			"kind": "block",
			"type": "turn"
		}
	]
}
blocks.forEach((block) => {
    toolbox.contents.push(getBlock(block))
})

function getBlock(block_id){
    switch (block_id){
        case "loop_1":
            return {
                "kind": "block",
                "type": "controls_repeat_ext"
            };
        case "math_1":
            return {
                "kind": "block",
                "type": "math_number"
            };
    }
}


var workspace = Blockly.inject('blocklyDiv', { toolbox: toolbox });

var startBlock = workspace.newBlock('start');
startBlock.moveBy(10, 10)
startBlock.setDeletable(false);
startBlock.setMovable(false);

startBlock.initSvg();
workspace.render();

const button = document.getElementById("generate")

let timeout = 0;

button.addEventListener('click', () => {
	timeout = 0;
    playerDirection = 1;
    drawPlayer()

    setTimeout(() => {
        let jsCode = javascriptGenerator.workspaceToCode(workspace);
        let functions = splitFunctions(jsCode);
        for (let i = 0; i < functions.length; i++) {
            setTimeout(() => {
                eval(functions[i])
                checkLoss();
            }, (1000 * i))
            setTimeout(() => {
                checkLoss();
            }, ((1000 * i) + 500))
        }
        setTimeout(() => {
            checkWin();
        }, (1000 * functions.length))
    }, 300)
})

function splitFunctions(str) {
    // Use a regular expression to match all function calls with or without arguments
    const regex = /\w+\((?:(?:"(?:\\.|[^"\\])*")|(?:'(?:\\.|[^'\\])*')|[^)]*)*\)/g;
    const matches = str.match(regex);

    // If there are no matches, return an empty array
    if (!matches) {
        return [];
    }

    return matches;
}

function countFunctions(str) {
    // Use a regular expression to match all function calls
    const regex = /\w+\(\)/g;
    const matches = str.match(regex);

    // If there are no matches, return 0
    if (!matches) {
        return 0;
    }

    // Otherwise, return the number of matches
    return matches.length;
}

function addBlock(Blockly, Block) {
	Blockly.defineBlocksWithJsonArray([Block.Structure()]);
	javascriptGenerator[Block.name] = Block.Logic(javascriptGenerator);
}

const canvas = document.getElementById("canvas");
const ctx = canvas.getContext('2d');
let grassCombination = [];
let obstacleCombination = [];
let obstaclesCombinationDone = false;
function startCanvas() {

	canvas.width = 320
	canvas.height = 320

	// fill the entire canvas with black before drawing the circles
	ctx.fillStyle = '#ffffff';
	ctx.fillRect(0, 0, canvas.width, canvas.height);
    let index = 0;

	for (var x = 0; x <= 7; x++) {
		for (var y = 0; y <= 7; y++) {
            let grass;
            if(grassCombination.length >= 64){
                grass = grasses[grassCombination[index]];
                index++;
            }else{
                let grassType = Math.floor(Math.random() * 3);
                grass = grasses[grassType];
                grassCombination.push(grassType)
            }

            ctx.drawImage(grass, x * 40, y * 40);
        }
	}
}

let playerX;
let playerY;
let playerDirection;
let goalX;
let goalY;
let finished;
let routes = [];

start()

let space = 0;
let playerPos;
let goalPos;
function start(){

    playerPos = JSON.parse(main.getAttribute("data-player"))
    playerX = playerPos[0];
    playerY = playerPos[1];

    goalPos = JSON.parse(main.getAttribute("data-goal"))
    goalX = goalPos[0];
    goalY = goalPos[1];
    playerDirection = 1;

    finished = false;
    let route = JSON.parse(main.getAttribute("data-route"))
    routes = [...route, playerPos, goalPos];

	drawPlayer()
}

function drawRoute(){
    obstacleCords = getObstacleCords(routes)
    obstacleCordsString = nestedArrayToString(obstacleCords);
    delete obstacleCordsString[playerPos.join[","]]
    delete obstacleCordsString[goalPos.join[","]]
    let obstacleIndex = 0;
    obstacleCords.forEach((cord) => {
        drawObstacleAt(...cord, obstacleIndex)
        obstacleIndex++
    })
    obstaclesCombinationDone = true;
}

function getObstacleCords(coords) {
    // Create an empty 8x8 matrix
    const matrix = new Array(8).fill(null).map(() => new Array(8).fill(false));

    // Loop through the given coordinates and mark them as present in the matrix
    for (const coord of coords) {
        const [row, col] = coord;
        matrix[row][col] = true;
    }

    // Loop through the matrix and find the missing coordinates
    const missingCoords = [];
    for (let row = 0; row < 8; row++) {
        for (let col = 0; col < 8; col++) {
            if (!matrix[row][col]) {
                missingCoords.push([row, col]);
            }
        }
    }

    return missingCoords;
}

function drawObstacleAt(x, y, obstacleIndex){
    let obstacle;
    if(obstaclesCombinationDone){
        obstacle = obstacles[obstacleCombination[obstacleIndex]];
    }else{
        let obstacleType = Math.floor(Math.random() * 6);
        obstacle = obstacles[obstacleType];
        obstacleCombination.push(obstacleType)
    }
    ctx.drawImage(obstacle, (40 * x), (40 * y));
}

function drawGoalAt() {
    ctx.drawImage(goalImg, 40 * goalX, 40 * goalY);
}

function calcPlayerToGoalDistance(){
    return [Math.round(playerX) - Math.round(goalX), Math.round(playerY) - Math.round(goalY)];
}

function checkWin(){
    let distance = calcPlayerToGoalDistance();
    if(distance[0] == 0 && distance[1] == 0 && finished == false){
        finished = true;
        modalWon.classList.remove('hidden');
        
        // Get level data
        const courseId = window.location.pathname.split('/')[2];
        const lessonId = window.location.pathname.split('/')[4];
        const levelId = window.location.pathname.split('/')[6];
        
        // Get Blockly code and commands count if available
        let blocklyCode = '';
        let commandsUsed = 0;
        
        try {
            // Use the new recommended method to get the main workspace
            if (typeof Blockly !== 'undefined') {
                const workspace = Blockly.getMainWorkspace();
                if (workspace) {
                    // Count blocks/commands used
                    commandsUsed = workspace.getAllBlocks(false).length;
                    
                    // Update the commands used count in the modal
                    const commandsUsedElement = document.getElementById('commands-used-value');
                    if (commandsUsedElement) {
                        commandsUsedElement.textContent = commandsUsed;
                    }
                    
                    // Check if Blockly.JavaScript is available
                    if (Blockly.JavaScript) {
                        blocklyCode = Blockly.JavaScript.workspaceToCode(workspace);
                    } else if (window.javascriptGenerator) {
                        // Alternative approach if using newer Blockly versions
                        blocklyCode = window.javascriptGenerator.workspaceToCode(workspace);
                    }
                }
            }
        } catch (error) {
            console.error('Error accessing Blockly workspace:', error);
        }
        
        // Send completion data to server
        fetch(`/course/${courseId}/lesson/${lessonId}/level/${levelId}/complete`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                code: blocklyCode || 'No code available',
                score: 100, // You can calculate this based on attempts, time, etc.
                commands_used: commandsUsed,
                completed: true
            })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Level completed:', data);
            
            // Update stats in the modal with the data from server
            if (data.progress) {
                // Update commands used
                const commandsUsedElement = document.getElementById('commands-used-value');
                if (commandsUsedElement) {
                    commandsUsedElement.textContent = data.progress.commands_used || commandsUsed;
                }
                
                // Update code quality using ID
                const codeQualityElement = document.getElementById('code-quality-value');
                if (codeQualityElement) {
                    codeQualityElement.textContent = data.progress.code_quality || 'Good';
                }
                
                // Update points earned using ID
                const pointsElement = document.getElementById('points-earned-value');
                if (pointsElement) {
                    pointsElement.textContent = '+' + (data.progress.points_earned || 50);
                }
            }
            
            // If next level is available, show a button to proceed
            if (data.nextLevel) {
                // Get container for next level button
                const nextLevelContainer = document.getElementById('next-level-container');
                if (nextLevelContainer) {
                    // Clear any existing content
                    nextLevelContainer.innerHTML = '';
                    
                    // Create a new button
                    const nextLevelBtn = document.createElement('a');
                    nextLevelBtn.href = data.nextLevel.url;
                    nextLevelBtn.className = 'py-2.5 px-6 bg-[#7BFF00] hover:bg-opacity-90 text-[#001E5F] font-bold rounded-lg transition-colors flex items-center gap-2';
                    nextLevelBtn.innerHTML = `
                        Next Level
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    `;
                    
                    // Add the button to the container
                    nextLevelContainer.appendChild(nextLevelBtn);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    } else {
        if(!failed){
            failed = true;
            modalLost.classList.remove('hidden');
            
            // Get level data for failed attempt tracking
            const courseId = window.location.pathname.split('/')[2];
            const lessonId = window.location.pathname.split('/')[4];
            const levelId = window.location.pathname.split('/')[6];
            
            // Get current Blockly code even though it failed
            let blocklyCode = '';
            let commandsUsed = 0;
            
            try {
                if (typeof Blockly !== 'undefined') {
                    const workspace = Blockly.getMainWorkspace();
                    if (workspace) {
                        // Count blocks/commands used
                        commandsUsed = workspace.getAllBlocks(false).length;
                        
                        if (Blockly.JavaScript) {
                            blocklyCode = Blockly.JavaScript.workspaceToCode(workspace);
                        } else if (window.javascriptGenerator) {
                            blocklyCode = window.javascriptGenerator.workspaceToCode(workspace);
                        }
                    }
                }
            } catch (error) {
                console.error('Error accessing Blockly workspace:', error);
            }
            
            // Track the failed attempt
            fetch(`/course/${courseId}/lesson/${lessonId}/level/${levelId}/attempt`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    code: blocklyCode || 'No code available',
                    commands_used: commandsUsed,
                    completed: false
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Attempt recorded:', data);
            })
            .catch(error => {
                console.error('Error recording attempt:', error);
            });
        }
    }
}

function checkLoss(){
    let currentStringPos = [Math.round(playerX), Math.round(playerY)].join(',');
    if(obstacleCordsString.includes(currentStringPos)){
        failed = true;
        modalLost.classList.remove('hidden')
    }
}

function nestedArrayToString(nestedArray) {
    return nestedArray.map(pair => pair.join(','));
}


function drawPlayer() {
	startCanvas()
    drawRoute();
    drawGoalAt()
    ctx.fillStyle = "#000";
	ctx.beginPath();
	if (playerDirection == 1) {
        ctx.drawImage(playerSprites[playerDirection], playerX * 40, playerY * 40);
	} else if (playerDirection == 0) {
        ctx.drawImage(playerSprites[playerDirection], playerX * 40, playerY * 40);

	} else if (playerDirection == 2) {
        ctx.drawImage(playerSprites[playerDirection], playerX * 40, playerY * 40);
	}
	else if (playerDirection == 3) {
        ctx.drawImage(playerSprites[playerDirection], playerX * 40, playerY  * 40);
	}
}

function move_forward(){
    if(!failed){
        for (let index = 0; index < 40; index++) {
            setTimeout(() =>{
                switch (playerDirection){
                    case 0:
                        playerY -= .025;
                        break
                    case 1:
                        playerX += .025;
                        break
                    case 2:
                        playerY += .025;
                        break
                    case 3:
                        playerX -= .025;
                        break
                }
                drawPlayer();
            }, 200);
        }
    }
}

function turn(direction){
    if(direction == "R"){
        playerDirection++;
    }else{
        playerDirection--;
    }

    if(playerDirection < 0){
        playerDirection = 3;
    }

    drawPlayer();
}
