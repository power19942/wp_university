import $ from 'jquery';

class Like {

    constructor(){
        this.events()
    }

    events(){
        $('.like-box').on('click',this.clickDispatcher.bind(this));
    }

    clickDispatcher(e){
        var likeBox = $(e.target).closest(".like-box");
        if(likeBox.data('exists') == 'yes'){
            this.deleteLike();
        }else{
            this.createLike();
        }
    }

    createLike(){
        $.ajax({
           url: `${universityData.root_url}/wp-json/university/v1/manageLike`,
           type: 'POST',
           success: (response)=>{
               console.log(response);
           },
           error: (err)=>{
               console.log(err);
           }
        });
    }

    deleteLike(){
        $.ajax({
            url: `${universityData.root_url}/wp-json/university/v1/manageLike`,
            type: 'DELETE',
            success: (response)=>{
                console.log(response);
            },
            error: (err)=>{
                console.log(err);
            }
        });
    }
}
export default Like;