<script type="text/x-template" id="tttIndex">
    <table class="table table-striped table-bordered">
        <caption><h3>Index</h3></caption>
        <thead>
        <tr>
            <th width="50px"></th>
            <th style="width: 120px;">Type</th>
            <th>Field</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="index in table.index.list">
            <td>
                <span v-on:click="remove(index)" class="btn btn-danger">X</span>
            </td>
            <td>
                <select v-model="index.type" class="form-control">
                    <option value="primary">primary</option>
                    <option value="unique">unique</option>
                    <option value="index">index</option>
                </select>
            </td>
            <td>
                <span v-for="field in index.field.list" class="border mr pull-left">
                    <div class="text-center" v-text="field.name"></div>
                    <div class="btn-group">
                        <span v-on:click="index.field.moveUp(field)" class="btn btn-info btn-xs">←</span>
                        <span v-on:click="index.field.moveDown(field)" class="btn btn-info btn-xs">→</span>
                        <span v-on:click="index.field.remove(field)" class="btn btn-danger btn-xs">X</span>
                    </div>
                </span>

                <span v-on:click="addField(index)" class="btn btn-info">+</span>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <span v-on:click="createIndex" class="btn btn-primary">+</span>
            </td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-index', {
        template: '#tttIndex',
        props: ['table'],
        methods: {
            createIndex: function () {
                let table = this.table;
                this.choose(function (yes, field) {
                    if (yes) {
                        let index = table.index.create(table.name + '_' + field.name, 'index');
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
                if(confirm('Are you sure?')){
                    this.table.index.remove(index);
                }
            },
            removeField: function (field, index) {
                if(confirm('Are you sure?')){
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
