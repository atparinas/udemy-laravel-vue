<script>
export default {
    props: ['answer'],
    data(){
        return {
            editing: false,
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionId: this.answer.id,
            beforeEditCache: null
        }
    },
    methods: {
        edit(){
            this.beforeEditCache = this.body;
            this.editing = true;
        },
        cancel(){
            this.body = this.beforeEditCache;
            this.editing = false;
        },
        update(){
            axios.patch(`/questions/${this.questionId}/answers/${this.id}`, {
                body: this.body
            }).then(response => {
                // console.log(response);
                this.editing = false
                this.bodyHtml = response.data.body_html
            }).catch(error => {
                console.log('Error Updating', error);
            })
        },
        destroy(){
            if(confirm('Are you sure?')){
                axios.delete(`/questions/${this.questionId}/answers/${this.id}`).then(response => {
                    $(this.$el).fadeOut(500, () => {
                        alert(response.data.message);
                    })
                }).catch(error => {
                    
                }); 
            }
        }
    }

}
</script>
