<script type="text/x-template" id="tttField">
    <table class="table">
        <caption>
            <h3>Field</h3>
        </caption>
        <thead>
        <tr>
            <th width="130px"></th>
            <th>Name</th>
            <th>Type</th>
            <th>Length</th>
            <th>Default</th>
            <th>Comment</th>
            <th>Nullable</th>
            <th>Unsigned</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in table.field.list">
            <td>
                <div class="btn-group">
                    <span v-on:click="table.field.moveUp(field)" class="btn btn-info">↑</span>
                    <span v-on:click="table.field.moveDown(field)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="remove(field)" class="btn btn-danger">X</span>
            </td>
            <td>
                <span v-on:click="rename(field)" class="btn btn-default" v-text="field.name"></span>
            </td>
            <td>
                <select v-model="field.type" class="form-control">
                    <option v-for="(ttt, key) in typeList" :value="key" v-text="key"></option>
                </select>
            </td>
            <td><input v-model="field.length" class="form-control" type="text"></td>
            <td><input v-model="field.value" class="form-control" type="text"></td>
            <td><input v-model="field.comment" class="form-control" type="text"></td>
            <td><input v-model="field.nullable" class="form-control" type="checkbox"></td>
            <td><input v-model="field.unsigned" class="form-control" type="checkbox"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="form-inline">
                <span v-on:click="add" class="btn btn-primary">+</span>
            </td>
            <td colspan="2" class="form-inline">
                <select v-model="selectedField" class="form-control">
                    <option v-for="field in fieldList" v-bind:value="field" v-text="field.name"></option>
                </select>
                <span v-on:click="addField" class="btn btn-info">+</span>
            </td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-field', {
        template: '#tttField',
        props: ['table'],
        data: function () {
            return {
                typeList: {
                    binary: null,
                    boolean: false,
                    char: '""',
                    date: '',
                    dateTime: '',
                    dateTimeTz: '',
                    decimal: 0,
                    double: 0,
                    float: 0,
                    'enum': '',
                    geometry: '',
                    increments: '',
                    integer: 0,
                    tinyInteger: 0,
                    smallInteger: 0,
                    mediumInteger: 0,
                    bigInteger: 0,
                    ipAddress: '',
                    json: '',
                    jsonb: '',
                    macAddress: '',
                    morphs: '',
                    string: '""',
                    text: '""',
                    mediumText: '""',
                    longText: '""',
                    time: '',
                    timeTz: '',
                    timestamp: null,
                    timestampTz: null,
                    uuid: '',
                    year: ''
                },
                fieldList: [
                    new Field('id', 'increments'),
                    new Field('user_id', 'integer'),
                    new Field('name', 'string', '""', 10),
                    new Field('status', 'integer', 0, 11),
                    new Field('remember_token', 'string', null, 100),
                    new Field('created_at', 'timestamp'),
                    new Field('updated_at', 'timestamp'),
                    new Field('deleted_at', 'timestamp')
                ],
                selectedField: null
            }
        },
        created: function () {
            let field = this.fieldList[4];
            field.nullable = true;
            field = this.fieldList[5];
            field.nullable = true;
            field = this.fieldList[6];
            field.nullable = true;
            field = this.fieldList[7];
            field.nullable = true;

            this.selectedField = this.fieldList[0];
        },
        methods: {
            add: function () {
                let name = prompt('Please enter the Field name');
                if (name) {
                    try {
                        let field = this.table.field.create(name, 'integer');
                        this.table.field.add(field);
                    } catch (exc) {
                        alert(exc);
                    }
                }
            },
            remove: function (field) {
                if (confirm('Are you sure?')) {
                    this.table.field.remove(field);
                }
            },
            rename: function (field) {
                let name = prompt('Please enter the Field name', field.name);
                if (name) {
                    try {
                        field.name = name;
                    } catch (exc) {
                        alert(exc);
                    }
                }
            },
            addField: function () {
                try {
                    this.table.field.add(this.selectedField);
                } catch (exc) {
                    alert(exc);
                }
            }
        }
    });

</script>
