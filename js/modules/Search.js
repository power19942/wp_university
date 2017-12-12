import $ from 'jquery';
class Search{
    constructor(){
        this.addSearchHTML();
        this.body = $('body');
        this.openBtn = $('.js-search-trigger');
        this.closeBtn = $('.search-overlay__close');
        this.searchOverly = $('.search-overlay');
        this.searchField = $('#search-term');
        this.Results = $('#search-overlay__result');
        this.events();
        this.isOpen = false;
        this.isSpinner = false;
        this.previousValue;
        this.typingTimer ;
    }

    events(){
        this.openBtn.on('click',this.openOverlay.bind(this));
        this.closeBtn.on('click',this.closeOverlay.bind(this));
        $(document).on('keydown',this.keyPress.bind(this));
        this.searchField.on('keyup',this.typingLogic.bind(this));
    }

    typingLogic(){
        if(this.searchField.val() != this.previousValue){
            clearInterval(this.typingTimer);
            if(this.searchField.val()){
                if(!this.isSpinner){
                    this.Results.html('<div class="spinner-loader"></div>');
                    this.isSpinner = true;
                }
                var that = this;



                this.typingTimer = setTimeout(()=>{
                    $.getJSON(`${universityData.root_url}/wp-json/university/v1/search?term=${that.searchField.val()}`,(results)=>{
                        that.Results.html(
                            `
                            <div class="row">
                                <div class="one-third">
                                    <h2 class="search-overlay__section-title">General Information</h2>
                                    ${results.generalInfo.length ? '<ul class="link-list min-list">' : '<p>No Post match the search</p>'}
                                        ${results.generalInfo.map(post=>`<li><a href="${post.permalink}">${post.title}</a> ${post.postType =='post' ? 'by '+post.authorName : ''}</li>`).join('')}
                                    ${results.generalInfo.length ? '</ul>' : ''}
                                </div>
                                <div class="one-third">
                                    <h2 class="search-overlay__section-title">Programs</h2>
                                    ${results.programs.length ? '<ul class="link-list min-list">' : '<p>No Post match the search</p>'}
                                        ${results.programs.map(post=>`<li><a href="${post.permalink}">${post.title}</a></li>`)}
                                    ${results.programs.length ? '</ul>' : ''}
                                    <h2 class="search-overlay__section-title">Professors</h2>
                                    ${results.professors.length ? '<ul class="professor-cards">' : '<p>No Post match the search</p>'}
                                        ${results.professors.map(post=>`
                                            <li class="professor-card__list-item">
                                                <a class="professor-card" href="${post.permalink}">
                                                    <img src="${post.img}" class="professor-card__image">
                                                    <span class="professor-card__name">${post.title}</span>
                                                </a>
                                            </li>
                                        `)}
                                    ${results.professors.length ? '</ul>' : ''}
                                </div>
                                <div class="one-third">
                                    <h2 class="search-overlay__section-title">Campuses</h2>
                                    ${results.campuses.length ? '<ul class="link-list min-list">' : '<p>No Post match the search</p>'}
                                         ${results.campuses.map(post=>`<li><a href="${post.permalink}">${post.title}</a></li>`)}
                                    ${results.campuses.length ? '</ul>' : ''}
                                    <h2 class="search-overlay__section-title">Events</h2>
                                    ${results.events.length ? '' : '<p>No Post match the search</p>'}
                                        ${results.events.map(post=>`
                                            <div class="event-summary">
                                                <a class="event-summary__date t-center" href="${post.permalink}">
                                                    <span class="event-summary__month">${post.month}</span>
                                                    <span class="event-summary__day">${post.day}</span>
                                                </a>
                                                <div class="event-summary__content">
                                                    <h5 class="event-summary__title headline headline--tiny"><a href="${post.permalink}">${post.title}</a></h5>
                                                    <p>${post.description}<a href="${post.permalink}" class="nu gray">Learn more</a></p>
                                                </div>
                                            </div>
                                        `)}
                                    ${results.events.length ? '' : ''}
                                </div>
                            </div>
                            `
                        );
                        this.isSpinner = false;
                    });
                    },1000);
            }else{
                this.Results.html('');
                this.isSpinner = false;
            }


        }
        this.previousValue = this.searchField.val();
    }

    openOverlay(){
        this.body.addClass("body-no-scroll");
        this.searchField.val('');
        this.Results.html('');
        setTimeout(()=>this.searchField.focus(),301);
        this.searchOverly.addClass('search-overlay--active');
        this.isOpen = true;
    }

    closeOverlay(){
        this.body.removeClass("body-no-scroll");
        this.searchOverly.removeClass('search-overlay--active');
        this.isOpen = false;
    }

    keyPress(e){
        if (e.keyCode === 83 && !this.isOpen && !$('input, textarea').is(':focus')){
            this.openOverlay();
        }
        if (e.keyCode === 27 && this.isOpen){
            this.closeOverlay();
        }
    }

    addSearchHTML(){
        $('body').append(`
        <div class="search-overlay">
            <div class="search-overlay__top">
                <div class="container">
                    <i class="fa fa-search search-overlay__icon" aria-hidden="true"></i>
                    <input type="text" class="search-term" placeholder="What are you looking for ?" id="search-term">
                    <i class="fa fa-window-close search-overlay__close" aria-hidden="true"></i>
                </div>
            </div>
            <div class="container">
                <div id="search-overlay__result"><div>
            </div>
        </div>
        `);
    }
}

export default Search;