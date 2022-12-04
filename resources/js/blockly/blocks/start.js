export function Structure(){
    return {
        "type": "start",
        "message0": "kur fillon",
        "nextStatement": null,
        "colour": 230,
        "tooltip": "",
        "helpUrl": ""
    }
}

export function Logic(){
    return function (block) {
        // String or array length.
      
        return 'start();';
      };
}

export const name = "start";