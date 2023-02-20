import * as Blockly from 'blockly';
import 'blockly/blocks'
import 'blockly/core'
import { translate } from "./translations";
import * as Forward from "./blockly/blocks/forward";
import * as Start from "./blockly/blocks/start";
import * as Turn from "./blockly/blocks/turn";

import { javascriptGenerator } from 'blockly/javascript'
import { dropWhile } from 'lodash';

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

for(let i = 1; i < 11; i++){
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
        eval(jsCode)
    }, 300)

})

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
    console.log(grassCombination.length)
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

function start(){
    let main = document.getElementById("main");

    let playerPos = JSON.parse(main.getAttribute("data-player"))
    playerX = playerPos[0];
    playerY = playerPos[1];

    let goalPos = JSON.parse(main.getAttribute("data-goal"))
    goalX = goalPos[0];
    goalY = goalPos[1];
    playerDirection = 1;

    finished = false;
    let route = JSON.parse(main.getAttribute("data-route"))
    routes = [...route, playerPos, goalPos];

	drawPlayer()
}

function drawRoute(){
    console.log(routes)
    let obstacleCords = getObstacleCords(routes)
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
        let obstacleType = Math.floor(Math.random() * 10);
        obstacle = obstacles[obstacleType];
        obstacleCombination.push(obstacleType)
    }
    console.log("ob")
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
        // alert("You WON!")
        finished = true;
    }
}

function drawPlayer() {
	startCanvas()
    drawRoute();
    drawGoalAt()
    checkWin()
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
	setTimeout(() => {
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
	}, timeout * 1000)
	timeout++;
}

function turn(direction){
	setTimeout(() => {
		if(direction == "R"){
			playerDirection++;
		}else{
			playerDirection--;
		}

        if(playerDirection < 0){
            playerDirection = 3;
        }

		drawPlayer();
	}, timeout * 1000)
	timeout++;
}
