import * as Blockly from 'blockly';
import 'blockly/blocks'
import 'blockly/core'
import { translate } from "./translations";
import * as Forward from "./blockly/blocks/forward";
import * as Start from "./blockly/blocks/start";
import * as Turn from "./blockly/blocks/turn";

import { javascriptGenerator } from 'blockly/javascript'
import { dropWhile } from 'lodash';

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
	let jsCode = javascriptGenerator.workspaceToCode(workspace);
	eval(jsCode)
})

function addBlock(Blockly, Block) {
	Blockly.defineBlocksWithJsonArray([Block.Structure()]);
	javascriptGenerator[Block.name] = Block.Logic(javascriptGenerator);
}

let canvas;
let ctx;

starCanvas()

function starCanvas() {
	canvas = document.getElementById("canvas");
	ctx = canvas.getContext('2d');

	canvas.width = 320
	canvas.height = 320

	// fill the entire canvas with black before drawing the circles
	ctx.fillStyle = '#ffffff';
	ctx.fillRect(0, 0, canvas.width, canvas.height);

	for (var x = 0; x <= 8; x++) {
		for (var y = 0; y <= 8; y++) {
			ctx.fillStyle == "#ffffff" ? ctx.fillStyle = "#BC89FF" : ctx.fillStyle = "#ffffff";
			ctx.fillRect(40 * x, 40 * y, 40, 40);
		}
	}
}

let playerX;
let playerY;
let playerDirection;
let goalX;
let goalY;

start()

let space = 0;

function start(){
	playerX = 3;
	playerY = 5;
	playerDirection = 1;
	goalX = 5;
	goalY = 5;
	
	drawPlayer()
}

function drawGoalAt() {
	ctx.fillStyle = "#000";
	ctx.fillRect(40 * goalX, 40 * (goalY - 1), 40, 40);
}

function drawPlayer() {
	starCanvas()
	drawGoalAt()
	ctx.fillStyle = "#000";
	ctx.beginPath();
	if (playerDirection == 1) {
		ctx.moveTo((playerX - 1) * 40, playerY * 40);
		ctx.lineTo(playerX * 40, (playerY * 40) - 20);
		ctx.lineTo((playerX - 1) * 40, (playerY - 1) * 40);
		ctx.fill();
	} else if (playerDirection == 0) {
		ctx.moveTo((playerX - 1) * 40, playerY * 40);
		ctx.lineTo((playerX * 40), (playerY * 40));
		ctx.lineTo((playerX * 40) - 20, (playerY - 1) * 40);
		ctx.fill();
	} else if (playerDirection == 2) {
		ctx.moveTo((playerX * 40) - 20, playerY * 40);
		ctx.lineTo((playerX * 40), ((playerY - 1) * 40));
		ctx.lineTo((playerX * 40) - 40, (playerY - 1) * 40);
		ctx.fill();
	}
	else if (playerDirection == 3) {
		ctx.moveTo((playerX) * 40, ((playerY - 1) * 40));
		ctx.lineTo(playerX * 40, (playerY * 40));
		ctx.lineTo((playerX - 1) * 40, (playerY * 40) - 20);
		ctx.fill();
	}
}

function move_forward(){
	setTimeout(() => {
		for (let index = 0; index < 40; index++) {
			setTimeout(() =>{
				playerX += .025;		
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
	
		drawPlayer();
	}, timeout * 1000)
	timeout++;

	
}