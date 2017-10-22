@verbatim
<script type="text/x-template" id="tttIndex">
    <table class="table table-striped table-bordered">
        <caption><h3>Index</h3></caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th style="width: 22%;">Name</th>
            <th style="width: 120px;">Type</th>
            <th>Field</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="index in table.index.list">
            <td>
                <button v-on:click="remove(index)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="index.name" class="form-control" type="text"></td>
            <td>
                <select v-model="index.type" class="form-control">
                    <option value="primary">primary</option>
                    <option value="unique">unique</option>
                    <option value="index">index</option>
                </select>
            </td>
            <td>
                <span v-for="field in index.field.list" class="border margin pull-left">
                    <div class="text-center">{{field.name}}</div>
                    <div class="btn-group">
                        <span v-on:click="index.field.moveUp(field)" class="btn btn-primary btn-xs">←</span>
                        <span v-on:click="index.field.moveDown(field)" class="btn btn-primary btn-xs">→</span>
                        <span v-on:click="index.field.remove(field)" class="btn btn-danger btn-xs">X</span>
                    </div>
                </span>

                <button v-on:click="addField(index)" class="btn btn-info" type="button">+</button>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="createIndex" class="btn btn-primary" type="button">+</button>
            </td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>
@endverbatim


<script type="text/javascript">

    Vue.component('ccc-index', {
        template: '#tttIndex',
        props: ['table'],
        methods: {
            createIndex: function () {
                let table = this.table;
                this.choose(function (yes, field) {
                    if (yes) {
                        let index = table.index.create(field.name, 'index');
                        index.field.create(field.name);
                    }
                });
            },
            addField: function (index) {
                this.choose(function (yes, field) {
                    if (yes) {
                        index.field.create(field.name);
                    }
                });
            },
            remove: function (index) {
                if(sure('Are you sure?')){
                    this.table.index.remove(index);
                }
            },
            removeField: function (field, index) {
                if(sure('Are you sure?')){
                    index.field.remove(field);
                }
            },
            choose: function (callback) {
                let data = {
                    message: 'Select a field',
                    display: 'name',
                    array: this.table.field.list,
                    callback: callback
                };
                showChoose(data);
            }
        }
    });

</script>
