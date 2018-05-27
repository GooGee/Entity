<script type="text/x-template" id="tttForm">
    <table class="table">
        <caption>
            <h3>Form</h3>
        </caption>
        <thead>
        <tr>
            <th width="130px"></th>
            <th>Field</th>
            <th>Type</th>
            <th>Value</th>
            <th>v-model</th>
            <th>Label</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="field in form.field.list">
            <td>
                <div class="btn-group">
                    <span v-on:click="form.field.moveUp(field)" class="btn btn-info">↑</span>
                    <span v-on:click="form.field.moveDown(field)" class="btn btn-info">↓</span>
                </div>
                <span v-on:click="remove(field)" class="btn btn-danger">X</span>
            </td>
            <td><input v-model="field.name" class="form-control" type="text"></td>
            <td>
                <select v-model="field.type" class="form-control">
                    <option value="text">text</option>
                    <option value="password">password</option>
                    <option value="hidden">hidden</option>
                    <option value="textarea">textarea</option>
                    <option value="checkbox">checkbox</option>
                    <option value="radio">radio</option>
                    <option value="select">select</option>
                </select>
            </td>
            <td><input v-model="field.value" class="form-control" type="text"></td>
            <td><input v-model="field.vModel" class="form-control" type="text"></td>
            <td><input v-model="field.label" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <span v-on:click="add" class="btn btn-primary">+</span>
            </td>
            <td>
                <span v-on:click="form.update()" class="btn btn-primary">All</span>
            </td>
            <td>
                <div class="btn-group">
                    <span v-on:click="method('GET')" v-bind:class="methodGet">GET</span>
                    <span v-on:click="method('POST')" v-bind:class="methodPost">POST</span>
                </div>
            </td>
            <td>
                <div class="btn-group">
                    <span v-on:click="method('PATCH')" class="btn btn-info">PATCH</span>
                    <span v-on:click="method('DELETE')" class="btn btn-info">DELETE</span>
                </div>
            </td>
            <td>
                <span v-on:click="setInstance()" class="btn btn-default">Set</span>
            </td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</script>


<script type="text/javascript">

    Vue.component('ccc-form', {
        template: '#tttForm',
        props: ['form'],
        computed: {
            methodGet: function () {
                if ('GET' == this.form.method) {
                    return 'btn btn-info active';
                }
                return 'btn btn-info';
            },
            methodPost: function () {
                if ('POST' == this.form.method) {
                    return 'btn btn-info active';
                }
                return 'btn btn-info';
            }
        },
        methods: {
            add: function () {
                let name = prompt('Please enter the Field name');
                if (name) {
                    let field = this.form.field.create(name, 'text');
                    this.form.field.add(field);
                }
            },
            remove: function (field) {
                if (confirm('Are you sure?')) {
                    this.form.field.remove(field);
                }
            },
            method: function (method) {
                if (method == 'GET') {
                    this.form.method = method;
                    return;
                }

                this.form.method = 'POST';
                let field = this.form.field.find('_method');
                if (field) {
                    //
                } else {
                    field = this.form.field.create('_method', 'hidden');
                    this.form.field.add(field);
                }

                if (method == 'PATCH') {
                    field.value = 'patch';
                }
                if (method == 'DELETE') {
                    field.value = 'delete';
                }
            },
            setInstance: function () {
                this.form.instance = prompt('Please enter the Instance name', this.form.instance);
            }
        }
    });

</script>
