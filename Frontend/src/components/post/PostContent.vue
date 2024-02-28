<script setup lang="ts">
import {ref} from "vue";
import ImageFullScreen from "@/components/post/ImageFullScreen.vue";

const imageSrc = ref("https://preview.redd.it/raniuszek-ponad-po%C5%82owa-zwierz%C4%99cia-to-ogon-ptasi-poniedzia%C5%82ek-v0-ahk5h64q0ijc1.jpeg?width=640&crop=smart&auto=webp&s=2f117f11d02397b3ec3e6b85fc25ae6dc273f0d3")
const isImageShown = ref(false)

</script>
<template>
    <div class="py-3" @click.stop >
        <div v-if="false">
            <p class="line-clamp-[6] text-white">
                Mam 26 lat. Magistra na karku. Do wczoraj marzenia. Tyle lat nauki, podczas studiów dodatkowe kursy.
                Cały czas się rozwijam i douczam. Na samym początku kariery trafiłam na bardzo toksyczne miejsce gdzie
                każdy starał się zgnoić młodego a druga połowa udawała że nie istnieje. Rzuciłam tą pracę bo nie dawałam
                rady psychicznie, zaczęły się napady paniki, sraczki i rzyganie na samą myśl o pracy. Potem starałam się
                dostać pracę wszędzie. Nie tylko w zawodzie. Na biedronki i sklepy mam za wysokie wykształcenie i to
                jeszcze nie w takim kierunku co by chcieli. Na jakieś pomoce nauczyciela w przedszkolach również (mimo
                że mam tu doświadczenie) cytat "bo gdzie pani ze swoimi studiami będzie pupy podcierać dzieciom".
                Składałam CV do prac wszędzie i chyba do każdej firmy w moim mieście. Jedynie gdzie wybrzydzam to praca
                fizyczna (również ze względów złych pleców) no i seks praca. Jestem wykształconą osobą. Poszerzającą
                swoją wiedzę a kurwa od 4 miesięcy nie mogę znaleźć pracy. Przerasta mnie to. Nie wiem co mam robić.
                Chodzenie do firm. Pisanie maili i dzwonienie nawet jak nie szukają nie pomaga. Od kilku miesięcy
                wszystko co mogło pójść źle idzie źle. Nie wiem co mam dalej robić
            </p>
        </div>
        <div @click="isImageShown = true" class="border border-gray-600 rounded-xl flex justify-center" v-else-if="true">
            <img class="object-contain max-h-[550px]"
                 :src="imageSrc"
                 alt="image">
            <transition name="slide-fade">
                <ImageFullScreen v-if="isImageShown" @close="isImageShown = false" :url="imageSrc"/>
            </transition>
        </div>
        <div v-else>
            <video controls id="video-controls" class="controls" data-state="hidden">
                <source src="http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4">
            </video>
        </div>
    </div>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.3s;
}
.slide-fade-enter-from,
.slide-fade-leave-to
{
    opacity: 0;
}
</style>