<template>
    <div id="toast-container" class="toast-container toast-top-right" v-show="stacks.length > 0">
        <div
            :class="['toast',{'toast-success':(stack.type=='success'),
            'toast-error':(stack.type=='error')}]"
            :aria-live="[{'polite':(stack.type=='success'),'assertive':(stack.type=='error')}]"
            style="display: block;"
            v-for="stack in stacks"
            :key="stack._uid"
        >

            <div class="toast-title">{{ stack.title }}</div>
            <div class="toast-message">{{ stack.body }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["title", "body", "type"],
        data() {
            return {
                stacks: [],
                timeoutStarted: false
            };
        },
        created() {
            if (this.title) {
                this.insertToStack(this.title, this.body, this.type);
            }
            window.events.$on("toast-stack", (title, body, type) => {
                this.insertToStack(title, body, type);
            });
        },
        mounted() {
            this.startTimeout();
        },
        methods: {
            insertToStack(title, body, type) {
                this.stacks.push({
                    title: title,
                    body: body,
                    type: type
                });
                this.timeoutStarted == false ? this.startTimeout() : null;
            },
            startTimeout() {
                this.timeoutStarted = true;
                setTimeout(() => {
                    this.removeFirstItem();
                }, 3000);
            },
            removeFirstItem() {
                this.stacks.splice(0, 1);
                if (this.stacks.length > 0) {
                    this.startTimeout();
                } else {
                    this.timeoutStarted = false;
                }
            }
        }
    };
</script>

<style>
    @import "/css/toastr.css";
</style>
