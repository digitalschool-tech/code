export function Structure(){
    return {
        "type": "forward",
        "message0": "ec perpara",
        "previousStatement": null,
        "nextStatement": null,
        "helpUrl": "%{BKY_COLOUR_RANDOM_HELPURL}",
        "style": "colour_blocks",
        "tooltip": "%{BKY_COLOUR_RANDOM_TOOLTIP}"
    }
}

export function Logic(javascriptGenerator){
    return function (block) {
        // String or array length.
        return 'move_forward();';
      };
}

export const name = "forward";