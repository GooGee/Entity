/// <reference path="./Entity/UniqueItem.ts" />

class FormField extends Entity.UniqueItem {
    type: string
    value: string
    label: string
    vModel: string

    constructor(name: string, type: string, value: string) {
        super(name);
        this.type = type;
        this.value = value;
        this.vModel = name;
        this.label = upperCapital(name);
    }

}
