<template>
  <k-field class="k-spacing-field" v-bind="$props">
    <div>
      <ul v-if="value.length === 0">
        <p>There are no comments available..</p>
      </ul>
      <ul v-else>
        <ul v-if="average.length !== 0">
          <p class="rating">Users have rated this picture {{ average }}/5</p>
        </ul>
        <li v-for="(comment) in comments" :key="comment.commentID" class="container">
          <div class="comment" >
            <p>{{ comment.username }}</p>
            <p>{{ comment.comment }}</p>
          </div>
          <button @click="openModal(comment.commentID)" class="delete-button"><k-icon type="trash"></k-icon></button>
        </li>
      </ul>

      <dialog ref="commentDialog" class="delete-dialog"  @click.self="closeDialog">
        <p>Do you really want to delete this comment?</p>
        <div class="dialog-buttons">
          <button @click="closeDialog"><k-icon type="cancel"></k-icon> <p>Cancel</p></button>
          <button @click="confirmDelete"><k-icon type="trash" style="color: red;"></k-icon> <p>Delete</p></button>
        </div>
      </dialog>
    </div>
  </k-field>
</template>

<script>
import {ref} from 'vue';
window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
export default {
  name: "Comments",
  extends: "k-field",
  props: {
    value: {
      type: Array,
    },
    average: {
      type: Number,
      default: 0
    },
  },
  data() {
      return {
        comments: this.value
      }
    },
  methods: {
    openModal(commentID) {
      this.selectedCommentID = commentID; 
      this.$refs.commentDialog.showModal(); 
    },
    closeDialog() {
      this.$refs.commentDialog.close(); 
    },
    confirmDelete() {
      this.deleteComment(this.selectedCommentID);
      this.closeDialog();
    },
    deleteComment(commentID) {
      fetch(`/comment/delete/${commentID}`, { method: 'DELETE' })
        .then((x) => {
           x.json().then(y => {
             this.comments = this.comments.filter((item) => item.commentID !== commentID);
            
            })
          
        })
        .catch((err) => {
          console.error('Delete failed:', err);
        });
    }
  }

};
</script>

<style>
/* css for the comment display */
.rating {
  background: #4e4e4e;
  padding: 8px;
  display: flex;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  color: white;
  width: 100%;
  border-radius: 5px;
  margin-top: 5px;
  border: 1px solid #e4e4e4;
}

.container {
  background: #fff;
  padding: 8px;
  display: flex;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  width: 100%;
  border-radius: 5px;
  margin-top: 5px;
  border: 1px solid #e4e4e4;
}

.container div:first-child {
  max-width:calc(100% - 30px);
  word-wrap: break-word;
  align-self: flex-start;
  flex: 50%;
}

.container p:first-child {
  font-weight: 600;
  padding: 3px;
}

.container p:nth-child(2) {
  width: 100%;
  color: rgb(110, 110, 110);
  padding: 4px;
}

.container p:nth-child(2)::before {
  content: '„';
}

.container p:nth-child(2)::after {
  content: '“';
}

.button {
  align-self: flex-end;
}

.delete-button {
  align-self: flex-end;
  color: #000000;
  padding: 0px;
}

.k-icon {
  margin: 0px 7px;
}


/* css for the dialog */
.dialog-container {
  display: flex;
  justify-content: center;
}

.delete-dialog {
  width: 352px; 
  border: none;
  border-radius: 7px; 
  padding: 1.5rem;
  background-color: white;
  box-shadow: 0 0px 10px rgba(0, 0, 0, 0.2); 
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); 
  z-index: 1000;
}

.delete-dialog p:first-child {
  margin-bottom: 20px;
}

.dialog-buttons {
  display: flex;
  justify-content: space-evenly;
}

.dialog-buttons button:first-child {
  display: flex;
  justify-content: center;
  background-color: #e7e7e7;
  border-radius: 4px;
  margin: 3px 5px;
  padding: 10px 34px;
}

.dialog-buttons button:first-child:hover {
  background-color: #E0E0E0;
}

.dialog-buttons button:nth-child(2) {
  display: flex;
  justify-content: center;
  background-color: #fcc0c0;
  border-radius: 4px;
  padding: 10px 35px;
  margin: 3px 5px;
  color: #530909;
}

.dialog-buttons button:nth-child(2):hover {
  background-color: #F6B1B1;
}

::backdrop {
  background-color: rgba(0, 0, 0, 0.5); 
}

.dialog-container {
  display: flex;
  justify-content: center;
  align-items: center;
}


</style>
