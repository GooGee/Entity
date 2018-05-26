
class Field extends Entity.UniqueItem {
    type: string
    value: string
    length: number

    constructor(name: string, type: string, value: string, length: number) {
        super(name);
        this.type = type;
        this.value = value;
        this.length = length;
    }

}
