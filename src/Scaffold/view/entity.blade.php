<script type="text/x-template" id="tttEntity">
    <table class="table table-striped table-bordered">
        <caption><h3>Entity</h3></caption>
        <thead>
        <tr>
            <th width="200px"></th>
            <th>Name</th>
            <th>Table</th>
            <th>Model</th>
            <th>Controller</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="entity in project.entity.list">
            <td>
                <div class="btn-group">
                    <button v-on:click="project.entity.moveUp(entity)" class="btn btn-info" type="button">↑</button>
                    <button v-on:click="project.entity.moveDown(entity)" class="btn btn-info" type="button">↓</button>
                </div>
                <button v-on:click="show(entity)" class="btn btn-primary" type="button">Show</button>
                <button v-on:click="remove(entity)" class="btn btn-danger" type="button">X</button>
            </td>
            <td><input v-model="entity.name" class="form-control" type="text"></td>
            <td><input v-model="entity.table.name" class="form-control" type="text"></td>
            <td><input v-model="entity.model.name" class="form-control" type="text"></td>
            <td><input v-model="entity.controller.name" class="form-control" type="text"></td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td>
                <button v-on:click="add" class="btn btn-primary" type="button">+</button>
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

    Vue.component('ccc-entity', {
        template: '#tttEntity',
        props: ['project'],
        methods: {
            add: function () {
                let name = input('Please enter the Entity name');
                if (isEmpty(name)) {
                    return;
                }
                this.project.entity.create(name);
            },
            show: function (entity) {
                this.$emit('show', entity);
            },
            remove: function (entity) {
                if(sure('Are you sure?')){
                    this.project.entity.remove(entity);
                }
            }
        }
    });

</script>
