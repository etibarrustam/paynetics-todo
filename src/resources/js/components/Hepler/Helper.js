const Helpers = {
    methods: {
        block(target, targetType = 'square-rotate') {
            let type = targetType;
            return this.$vs.loading({target: '#'+target, text: 'Loading...', type});
        },
        successNotification(message){
            const noti = this.$vs.notification({
                square: true,
                flat: true,
                progress: 'auto',
                color : 'rgb(59,222,200)',
                border : 'rgb(59,222,200)',
                position: 'top-right',
                title: 'Success',
                text: message,
            });
        },
        errorNotification(messages) {
            if (typeof messages === 'object') {
                return Object.keys(messages).forEach((msgKey) => {
                    messages[msgKey].forEach((msg) => {
                        this.$vs.notification({
                            square: true,
                            flat: true,
                            progress: 'auto',
                            color : 'danger',
                            border : 'danger',
                            position: 'top-right',
                            title: 'Error',
                            text: messages[msgKey],
                        });
                    });
                });
            }

            this.$vs.notification({
                square: true,
                flat: true,
                progress: 'auto',
                color : 'danger',
                border : 'danger',
                position: 'top-right',
                title: 'Error',
                text: messages,
            });
        },
    }
};
export default Helpers;
