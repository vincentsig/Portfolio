import { gsap } from "gsap";
import { CSSRulePlugin } from "gsap/CSSRulePlugin";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
gsap.registerPlugin(CSSRulePlugin);

if (screen.width > 720) { 

// Anim Hero
let tlhero = gsap.timeline({});
tlhero.from('.hero_content_intro', {opacity:0,ease:"easeIn",duration:1,ease:"easeIn"});
tlhero.from('.hero_intro_hook', {opacity:0,ease:"easeIn",duration:1,});
tlhero.from('.main-link', {opacity:0,duration:0.2,ease:"easeIn",stagger:"0.4"}, "-=0.2");
tlhero.from('.hero_imgCtn', {x:500,opacity:0,duration:1,ease:"easeIn"});
tlhero.from('.customnav', {opacity:0,duration:0.2,ease:"easeIn"});

// Anim Me
var tlme = gsap.timeline({
    scrollTrigger : { trigger:"#about",start:"bottom bottom", }
});
tlme.from(".about_me", {opacity:0,x:500,duration:0.8,ease:"ease"})
tlme.from(".skill_title", {opacity:0,duration:0.2,ease:"ease"})
tlme.from(".skills_list_box", {opacity:0,duration:0.8, stagger:0.5,ease:"ease"})

// Anim Project
let tlproject = gsap.timeline({scrollTrigger : { trigger:".category-button",start:"center bottom",}});
tlproject.from(".project_title", {  x: -500, ease:"powerIn", opacity:0, duration:0.5,})
tlproject.from(".category-button", {x:200, opacity:0,duration:0.2,stagger:0.1,ease:"slowMo"})
tlproject.from('.portfolio_gallery', {opacity:0,duration:2,ease:"linear"})

// Anim Contact
let tlcontact= gsap.timeline({scrollTrigger : { trigger:"#contact",start:"center bottom",}});
tlcontact.from (".contact_title", {  x: 500, ease:"powerIn", opacity:0, duration:0.5,});
tlcontact.from (".form-contact", {  x: 500, ease:"powerIn", opacity:0, duration:0.5,}, "-=0.5");
tlcontact.from (".ctn-image", {  y: 500, ease:"powerIn", opacity:0, duration:1,});

// footer
let tlfooter= gsap.timeline({scrollTrigger : { trigger:"footer",start:"top bottom"}});
tlfooter.from (".circle", { scale:0.2, ease:"powerIn", opacity:0,stagger:0.2})
.to (".anim-footerbloc ", {opacity:0,ease:"easeIn",duration:0.2});


}
