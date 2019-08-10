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
                    <option v-for="name in typeNameList" :value="name" v-text="name"></option>
                </select>
            </td>
            <td><input v-model="field.length" class="form-control" type="text"></td>
            <td><input v-model="field.value" class="form-control" type="text"></td>
            <td><input v-model="field.comment" class="form-control" type="text"></td>
            <td><input v-model="field.allowNull" class="form-control" type="checkbox"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2" class="form-inline">
                <select v-model="selectedField" class="form-control">
                    <option v-for="field in fieldList" v-bind:value="field" v-text="field.name"></option>
                </select>
                <span v-on:click="addField" class="btn btn-info">+</span>
            </td>
            <td colspan="2" class="form-inline">
                <select v-model="type" class="form-control">
                    <option v-for="field in fieldTypeList" v-bind:value="field.type" v-text="field.name"></option>
                </select>
                <span v-on:click="add" class="btn btn-primary">+</span>
            </td>
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
                type: 'string',
                typeNameList: TypeNameList,
                fieldList: CommonFieldList,
                fieldTypeList: FieldTypeList,
                selectedField: CommonFieldList[0]
            }
        },
        methods: {
            add: function () {
                let name = prompt('Please enter the Field name');
                if (name) {
                    try {
                        let field = this.table.field.create(name, this.type);
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
