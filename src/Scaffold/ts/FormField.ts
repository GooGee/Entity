
class FormField extends Entity.UniqueItem {
    type: string
    value: string
    label: string

    constructor(name: string, type: string, value: string) {
        super(name);
        this.type = type;
        this.value = value;
        this.label = upperCapital(name);
    }

}
