<script setup lang="ts">

import IconDots from "@/components/icons/IconDots.vue";
import IconShare from "@/components/icons/IconShare.vue";
import IconComments from "@/components/icons/IconComments.vue";
import ArrowUpIcon from "@/components/icons/ArrowUpIcon.vue";
import ArrowDownIcon from "@/components/icons/ArrowDownIcon.vue";
import {ref} from "vue";
import IconBookmark from "@/components/icons/IconBookmark.vue";
import IconUser from "@/components/icons/IconUser.vue";

const showMenu = ref(false)

const showCommunityInfo = ref(false)


</script>

<template>
    <div class="max-w-[700px] hover:bg-hover-light rounded-xl cursor-pointer select-none">

        <div class="rounded-r-md grow flex flex-col *:mx-4">
            <div class="text-sm mt-2 flex items-center gap-1">
                <div class="relative" @mouseover="showCommunityInfo = true"
                     @mouseleave="showCommunityInfo = false">
                    <p class="text-white hover:text-text-blue" >r/shitposting</p>
                    <transition name="slide-fade">
                        <div v-if="showCommunityInfo"
                             class="absolute bg-main-bg top-8 flex flex-col shadow-lg shadow-black select-text z-10    ">
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2"><icon-user/>r/shitposting</div>
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2">The realm of the most anti-climactic short stories from 4chan.</div>
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2"><div class="flex gap-32">
                                <div class="flex flex-col">
                                    <div>
                                        2.7M
                                    </div>
                                    <div>
                                        Members
                                    </div>
                                </div>

                                <div class="flex flex-col">
                                    <div>
                                        6.7K
                                    </div>
                                    <div>
                                        Online
                                    </div>
                                </div>
                            </div></div>
                        </div>
                    </transition>
                </div>

                <p class="text-gray-400 grow">&#x2022; 5 hours ago</p>
                <div class="hover:bg-hover-dark hover:rounded-full p-2 relative" @click.stop="showMenu = !showMenu">
                    <icon-dots />
                    <transition name="slide-fade">
                        <div @click.stop v-if="showMenu" class="absolute bg-main-bg right-0 top-8 flex flex-col shadow-lg shadow-black select-text">
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2"><icon-bookmark/>Save</div>
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2"><icon-bookmark/>Hide</div>
                            <div class="p-3 hover:bg-hover-light flex items-center gap-2"><icon-bookmark/>Report</div>
                        </div>
                    </transition>
                </div>
            </div>
            <div class="text-white text-xl">Mam dosyć</div>
            <div class="">
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
            <div class="flex justify-start gap-1 text-white py-1 text-sm">
                <div class="bg-[#1a282d] rounded-full cursor-pointer flex ">
                    <div class="hover:text-red-600 hover:bg-hover-dark flex rounded-full p-2">
                        <arrow-up-icon class="w-4 "/>
                    </div>

                    <div class="flex items-center">
                        2332
                    </div>

                    <div class="hover:text-blue-600 hover:bg-hover-dark flex rounded-full p-2">
                        <arrow-down-icon class="w-4"/>
                    </div>
                </div>

                <div class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
                    <IconComments/>
                    188
                </div>

                <div class="hover:bg-hover-dark bg-[#1a282d] rounded-full px-4 py-2 cursor-pointer flex items-center gap-1">
                    <IconShare/>
                    Share
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
.slide-fade-enter-active,
.slide-fade-leave-active {
    transition: all 0.1s;
}
.slide-fade-enter-from,
.slide-fade-leave-to
{
    opacity: 0;
}
</style>