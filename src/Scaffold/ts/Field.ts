/// <reference path="./Entity/UniqueItem.ts" />

type Basic = boolean | number | string | null

class Field extends Entity.UniqueItem {
    allowNull: boolean = false
    comment: string | null = null

    /**
     * if length is null
     * means field has no length
     * or length is provided automatically
     */
    length: number | string | null = null

    type: string

    /**
     * if value is null
     * means field has no default value
     */
    value: Basic = null

    constructor(name: string, type: string, value: Basic, allowNull: boolean = false) {
        super(name)
        this.type = type
        this.value = value
        this.allowNull = allowNull
    }

}

class EnumField extends Field {
    list: Array<string> = []

    constructor(name: string, type: string) {
        super(name, type, 0)
    }
}

class IncrementField extends Field {
    constructor(name: string, type: string) {
        super(name, type, null)
    }
}

class IntegerField extends Field {
    constructor(name: string, type: string) {
        super(name, type, 0)
    }
}

class RealField extends Field {
    constructor(name: string, type: string) {
        super(name, type, 0)
        this.length = '8, 2'
    }
}

class StringField extends Field {
    constructor(name: string, type: string, length: number | null = null, value: Basic = "''") {
        super(name, type, value)
        this.length = length
    }
}

class TextField extends Field {
    constructor(name: string, type: string) {
        super(name, type, "''")
    }
}

class TimeStamp extends Field {
    constructor(name: string, type: string) {
        super(name, type, null, true)
    }
}
