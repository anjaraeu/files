<template>
    <form method="POST" class="ui form" @submit.prevent="submitForm">
        <div class="field">
            <label for="reportdown">{{ this.$lang.get('group.report.reason._') }}</label>
            <select class="ui selection dropdown" id="reportdown" v-model="type">
                <option value="">{{ this.$lang.get('group.report.reason.placeholder') }}</option>
                <option value="spam">{{ this.$lang.get('group.report.reason.spam') }}</option>
                <option value="identity">{{ this.$lang.get('group.report.reason.identity') }}</option>
                <option value="shock">{{ this.$lang.get('group.report.reason.shock') }}</option>
                <option value="copyright">{{ this.$lang.get('group.report.reason.copyright') }}</option>
                <option value="confidential">{{ this.$lang.get('group.report.reason.confidential') }}</option>
            </select>
        </div>
        <div class="field" v-if="type === 'identity'">
            <label for="who">{{ this.$lang.get('group.report.identity.who._') }}</label>
            <input type="text" name="who" id="who" :placeholder="this.$lang.get('group.report.identity.who.placeholder')" v-model="who">
        </div>
        <div class="field" v-if="type === 'copyright'">
            <label for="who">{{ this.$lang.get('group.report.cp.who._') }}</label>
            <input type="text" name="who" id="who" :placeholder="this.$lang.get('group.report.cp.who.placeholder')" v-model="who">
        </div>
        <div class="field" v-if="type === 'copyright'">
            <label for="what">{{ this.$lang.get('group.report.cp.what._') }}</label>
            <input type="text" name="what" id="what" :placeholder="this.$lang.get('group.report.cp.what.placeholder')" v-model="what">
        </div>
        <div class="field" v-if="type === 'copyright'">
            <div class="ui checkbox">
                <input type="checkbox" name="dmca" id="dmca" v-model="dmca">
                <label for="dmca">{{ this.$lang.get('group.report.cp.dmca') }}</label>
            </div>
        </div>
        <div class="field" v-if="type === 'copyright'">
            <label for="sign">{{ this.$lang.get('group.report.cp.sign._') }}</label>
            <input type="text" name="sign" id="sign" :placeholder="this.$lang.get('group.report.cp.sign.placeholder')" v-model="sign">
        </div>
        <div class="field" v-if="isEncrypted">
            <label for="password">{{ this.$lang.get('group.report.password._') }}</label>
            <input type="text" name="password" id="password" :placeholder="this.$lang.get('group.report.password.placeholder')" v-model="password">
        </div>
        <div class="field" v-if="type !== null">
            <button type="submit" class="ui blue button" v-bind:class="{loading, disabled: done}">
                {{ this.done ? this.$lang.get('group.report.done'):this.$lang.get('group.report.submit') }}
            </button>
            <small v-if="warning">{{ warning }}</small>
        </div>
    </form>
</template>

<script>
export default {
    props: ['slug', 'encrypted', 'fileslug'],

    data() {
        return {
            type: null,
            who: '',
            what: '',
            dmca: false,
            sign: '',
            password: '',
            warning: false,
            loading: false,
            done: false
        }
    },

    methods: {
        goHome() {
            return window.location.replace(this.$env.url);
        },
        sendReport() {
            axios.post(`/g/${this.slug}/report`, {
                type: this.type,
                who: this.who,
                what: this.what,
                password: this.password,
                sign: this.sign
            }).then(res => {
                this.loading = false;
                this.done = true;
                window.setTimeout(this.goHome, 2500);
            }).catch(err => {
                this.loading = false;
            });
        },
        submitForm() {
            if (this.type === 'copyright' && !this.dmca) {
                this.warning = this.$lang.get('group.report.err.dmca');
                return false;
            }
            this.loading = true;
            if (this.isEncrypted) {
                axios.get('/f/'+this.fileslug+'/check', { params: {
                    password: this.password
                }}).then(res => {
                    if (res.data === true) this.sendReport();
                    else {
                        this.warning = this.$lang.get('group.report.err.password');
                        this.loading = false;
                    }
                });
            } else this.sendReport();

        }
    },

    computed: {
        isEncrypted() {
            return this.encrypted === '1' || this.encrypted === 'true';
        }
    }

}
</script>
