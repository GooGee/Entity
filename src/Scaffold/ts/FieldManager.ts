/// <reference path="./Entity/UniqueList.ts" />
/// <reference path="./Field.ts" />

class FieldManager extends Entity.UniqueList<Field> {

    clone(field: Field) {
        const fff = new Field(field.name, field.type, field.value, field.allowNull)
        fff.load(field)
        return fff
    }

    create(name: string, type: string) {
        const field = FieldManager.findFieldType(type)
        if (field) {
            const fff = this.clone(field)
            fff.name = name
            return fff
        }
        throw new Error('Unknown field type!')
    }

    load(object: any) {
        let array: Field[]
        if (Array.isArray(object)) {
            array = object
        } else {
            if (Array.isArray(object.list)) {
                array = object.list
            } else {
                return
            }
        }

        this.clear()
        array.forEach(item => {
            const field = this.clone(item)
            this.add(field)
        })
    }

    static findFieldType(type: string) {
        return FieldTypeList.find(field => {
            return field.type == type
        })
    }
}

const CommonFieldList = [
    new IncrementField('id', 'increments'),
    new IntegerField('user_id', 'integer'),
    new IntegerField('category_id', 'integer'),
    new IntegerField('parent_id', 'integer'),
    new IntegerField('sort', 'integer'),
    new IntegerField('status', 'integer'),
    new StringField('name', 'string', 11, null),
    new StringField('title', 'string', 33, null),
    new StringField('email', 'string', 33, null),
    new StringField('phone', 'char', 11),
    new StringField('password', 'string', null, null),
    new Field('remember_token', 'string', null, true),
    new TimeStamp('created_at', 'timestamp'),
    new TimeStamp('updated_at', 'timestamp'),
    new TimeStamp('deleted_at', 'timestamp'),
]

const FieldTypeList = [

    new IncrementField('bigIncrements', 'bigIncrements'),
    new IncrementField('increments', 'increments'),
    new IncrementField('mediumIncrements', 'mediumIncrements'),
    new IncrementField('smallIncrements', 'smallIncrements'),
    new IncrementField('tinyIncrements', 'tinyIncrements'),

    new IntegerField('bigInteger', 'bigInteger'),
    new IntegerField('integer', 'integer'),
    new IntegerField('mediumInteger', 'mediumInteger'),
    new IntegerField('smallInteger', 'smallInteger'),
    new IntegerField('tinyInteger', 'tinyInteger'),

    new IntegerField('unsignedBigInteger', 'unsignedBigInteger'),
    new IntegerField('unsignedInteger', 'unsignedInteger'),
    new IntegerField('unsignedMediumInteger', 'unsignedMediumInteger'),
    new IntegerField('unsignedSmallInteger', 'unsignedSmallInteger'),
    new IntegerField('unsignedTinyInteger', 'unsignedTinyInteger'),

    new Field('binary', 'binary', null, true),

    new Field('boolean', 'boolean', false),

    new StringField('char', 'char'),
    new StringField('string', 'string'),

    new TextField('text', 'text'),
    new TextField('mediumText', 'mediumText'),
    new TextField('longText', 'longText'),

    new Field('date', 'date', '2000-01-01'),
    new Field('dateTime', 'dateTime', '2000-01-01 00:00:00'),
    new Field('dateTimeTz', 'dateTimeTz', '2000-01-01 00:00:00'),

    new RealField('decimal', 'decimal'),
    new RealField('double', 'double'),
    new RealField('float', 'float'),
    new RealField('unsignedDecimal', 'unsignedDecimal'),

    new EnumField('enum', 'enum'),

    new Field('time', 'time', '00:00:00'),
    new Field('timeTz', 'timeTz', '00:00:00'),

    new TimeStamp('timestamp', 'timestamp'),
    new TimeStamp('timestampTz', 'timestampTz'),

    new Field('uuid', 'uuid', null),

    new Field('year', 'year', '2000'),


    new Field('geometry', 'geometry', null),
    new Field('geometryCollection', 'geometryCollection', null),

    new Field('ipAddress', 'ipAddress', null),

    new Field('json', 'json', null),
    new Field('jsonb', 'jsonb', null),

    new Field('lineString', 'lineString', null),
    new Field('multiLineString', 'multiLineString', null),

    new Field('macAddress', 'macAddress', null),

    new Field('morphs', 'morphs', null),
    new Field('nullableMorphs', 'nullableMorphs', null),

    new Field('point', 'point', null),
    new Field('multiPoint', 'multiPoint', null),

    new Field('polygon', 'polygon', null),
    new Field('multiPolygon', 'multiPolygon', null),

]

/**
 * Laravel 5.8
 */
const TypeNameList = [
    'bigIncrements',
    'bigInteger',
    'binary',
    'boolean',
    'char',
    'date',
    'dateTime',
    'dateTimeTz',
    'decimal',
    'double',
    'enum',
    'float',
    'geometry',
    'geometryCollection',
    'increments',
    'integer',
    'ipAddress',
    'json',
    'jsonb',
    'lineString',
    'longText',
    'macAddress',
    'mediumIncrements',
    'mediumInteger',
    'mediumText',
    'morphs',
    'multiLineString',
    'multiPoint',
    'multiPolygon',
    'nullableMorphs',
    'nullableTimestamps',
    'point',
    'polygon',
    'rememberToken',
    'smallIncrements',
    'smallInteger',
    'softDeletes',
    'softDeletesTz',
    'string',
    'text',
    'time',
    'timeTz',
    'timestamp',
    'timestampTz',
    'tinyIncrements',
    'tinyInteger',
    'unsignedBigInteger',
    'unsignedDecimal',
    'unsignedInteger',
    'unsignedMediumInteger',
    'unsignedSmallInteger',
    'unsignedTinyInteger',
    'uuid',
    'year',
]
