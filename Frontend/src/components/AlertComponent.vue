<template>
<div :class="alertClass" v-if="visible">
    <span class="closebtn" @click="closeAlert">&times;</span>
    {{ message }}
</div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true,
            validator(value) {
                return ['success', 'warning', 'failed'].includes(value);
            }
        },
        duration: {
            type: Number,
            default: 3000
        }
    },
    data() {
        return {
            visible: true
        }
    },
    computed: {
        alertClass() {
            return {
                'alert': true,
                'alert-success': this.type === 'success',
                'alert-warning': this.type === 'warning',
                'alert-failed': this.type === 'failed',
            };
        }
    },
    methods: {
        closeAlert() {
            this.visible = false;
        }
    },
    mounted() {
        setTimeout(() => {
            this.visible = false;
        }, this.duration);
    }
}
</script>

<style scoped>
div {
    width: 30%;
}

.alert {
    padding: 10px;
    margin-bottom: 15px;
}

.alert-success {
    background-color: #4CAF50;
    font-size: 15px;
    color: white;
}

.alert-warning {
    background-color: #ff9800;
    font-size: 15px;
    color: white;
}

.alert-failed {
    background-color: #f44336;
    font-size: 15px;
    color: white;
}

.closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
}

.closebtn:hover {
    color: black;
}
</style>
