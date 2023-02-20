
export default [
  {
    title: 'Product Category',
    icon: { icon: 'tabler-chart-donut' },
    to: 'diya-category'
    // children: [
    //   {
    //     title: 'Category1',
    //     icon: { icon: 'a' },
    //     to: 'diya-category',
    //     id: '1',
    //   },
    //     {
    //     title: 'Category2',
    //     icon: { icon: 'a' },
    //     to: 'apps-email',
    //   }
    // ],
  },
]

// import axios from "axios";
//
// export default {
//     data() {
//         return{
//             categoryList: []
//         }
//     },
//     created() {
//         axios.post('http://192.168.58.42:3000/api/site/action', {action: 'categoryList', lang_id: localStorage.lang_id})
//             .then(result => {
//                 // console.log(result.data)
//                 this.categoryList = result.data
//               export default this.categoryList
//                 // console.log(JSON.parse(JSON.stringify(this.categoryList)))
//                             });
//     }
// }
