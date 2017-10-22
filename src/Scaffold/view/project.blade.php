<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Entity</title>

    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>

    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/entity.css">

    <script type="text/javascript">
        const vd = {};
        const vm = {};
    </script>
    <script type="text/javascript" src="/js/es6-promise.auto.min.js"></script>
    <script type="text/javascript" src="/js/axios.min.js"></script>
    <script type="text/javascript" src="/js/vue.js"></script>
    <script type="text/javascript" src="/js/entity.js"></script>
</head>
<body>
<!--[if lt IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please
    <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<div id="entity">

    @include('entity::header')

    @verbatim
    <div class="container">

        <!-- Project -->
        <div v-show="tab=='project'">
            <h3>{{project.name}}
                <button v-on:click="saveProject" class="btn btn-success" type="button">Save</button>
            </h3>

            <!-- Property -->
            <ccc-property :object="project"></ccc-property>

            <!-- Entity -->
            <ccc-entity :project="project" v-on:show="showEntity"></ccc-entity>
        </div>


        <!-- Migration -->
        <div v-if="entity" v-show="tab=='table'">
            <h3>{{entity.table.name}}
                <button v-on:click="saveMigration" class="btn btn-success" type="button">Save</button>
            </h3>

            <!-- Property -->
            <ccc-property :object="entity.table"></ccc-property>

            <!-- Field -->
            <ccc-field :table="entity.table"></ccc-field>

            <!-- Index -->
            <ccc-index :table="entity.table"></ccc-index>
        </div>


        <!-- Model -->
        <div v-if="entity" v-show="tab=='model'">
            <h3>{{entity.model.name}}
                <button v-on:click="saveModel" class="btn btn-success" type="button">Save</button>
            </h3>

            <!-- Property -->
            <ccc-property :object="entity.model"></ccc-property>

            <!-- Relation -->
            <ccc-relation :model="entity.model"></ccc-relation>

            <!-- Validation -->
            <ccc-validation :model="entity.model"></ccc-validation>
        </div>


        <!-- Controller -->
        <div v-if="entity" v-show="tab=='controller'">
            <h3>{{entity.controller.name}}
                <button v-on:click="saveController" class="btn btn-success" type="button">Save</button>
            </h3>

            <!-- Property -->
            <ccc-property :object="entity.controller"></ccc-property>

            <!-- Middleware -->
            <ccc-middleware :controller="entity.controller"></ccc-middleware>
        </div>


        <!-- Form -->
        <div v-if="entity" v-show="tab=='form'">
            <h3>{{entity.name}}
                <button v-on:click="saveForm" class="btn btn-success" type="button">Save</button>
            </h3>

            <!-- Form -->
            <ccc-form :form="entity.form"></ccc-form>
        </div>

    </div>
    @endverbatim


            <!-- Choose -->
    <div v-show="choose.visible">
        <ccc-choose :data="choose.data"></ccc-choose>
    </div>

</div>
<br>

@include('entity::choose')

@include('entity::property')
@include('entity::entity')
@include('entity::field')
@include('entity::index')
@include('entity::relation')
@include('entity::validation')
@include('entity::middleware')
@include('entity::form')

<script type="text/javascript">

    //window.onload = function () {
    //
    //};

    function toJSON(object) {
        let array = [];

        return JSON.stringify(object, function (key, value) {
            if (typeof(value) === 'object') {
                if (value !== null) {
                    if (array.indexOf(value) >= 0) {
                        return;
                    }
                    array.push(value);
                }
            }

            return value;
        });
    }

    vm.show = function (tab) {
        vd.tab = tab;
    };

    vm.showEntity = function (entity) {
        this.entity = entity;
        vm.show('table');
    };

    vm.saveProject = function () {
        let json = toJSON(this.project);
        let data = {project: json};
        save('/entity', data);
    };

    vm.saveMigration = function () {
        let json = toJSON(this.entity);
        let data = {entity: json};
        save('/entity/table', data);
    };

    vm.saveModel = function () {
        let json = toJSON(this.entity);
        let data = {entity: json};
        save('/entity/model', data);
    };

    vm.saveController = function () {
        let json = toJSON(this.entity);
        let data = {entity: json};
        save('/entity/controller', data);
    };

    vm.saveForm = function () {
        let json = toJSON(this.entity);
        let data = {entity: json};
        save('/entity/form', data);
    };


    function Load(data) {
        let project = new Project('Project');
        project.load(data);

        vd.tab = 'project';
        vd.choose = choose;
        vd.entity = null;
        vd.project = project;
    }

    Load(@echo($project));

    const vvv = new Vue({
        el: '#entity',
        data: vd,
        methods: vm,
        mounted: function () {
            //console.log(vd);
        }
    });

</script>

</body>
</html>