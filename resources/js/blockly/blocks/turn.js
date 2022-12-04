export function Structure(){
    return {
        "type": "turn",
        "message0": "%1 %2",
        "args0": [
          {
            "type": "field_label_serializable",
            "name": "turn",
            "text": "kthehu"
          },
          {
            "type": "field_dropdown",
            "name": "turn_value",
            "options": [
              [
                "majtas",
                "L"
              ],
              [
                "djathtas",
                "R"
              ]
            ]
          }
        ],
        "previousStatement": null,
        "nextStatement": null,
        "colour": 230,
        "tooltip": "Moves Forward one space.",
        "helpUrl": ""
    }
}

export function Logic(javascriptGenerator){
    return function (block) {
      let dropdown_turn_value = block.getFieldValue('turn_value');
        return 'turn("' + dropdown_turn_value + '");';
      };
}

export const name = "turn";