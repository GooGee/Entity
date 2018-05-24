
<template id="tttDialogue">
<div class="modal" tabindex="-1" role="dialog" style="display: block; margin-top: 55px">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span v-show="dialogue.canClose" v-on:click="$emit('hide')" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span></span>
                <h4 class="modal-title">
                    <slot name="title"></slot>
                </h4>
            </div>
            <div class="modal-body">
                <slot name="body"></slot>
            </div>
            <div v-show="dialogue.footer" class="modal-footer">
                <slot name="footer"></slot>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</template>


<script type="text/javascript">

Vue.component('ccc-dialogue', {
    template: '#tttDialogue',
    props: ['dialogue']
});

</script>
