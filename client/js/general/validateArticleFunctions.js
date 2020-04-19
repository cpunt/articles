function validateTitle(title) {
  const titleLen = title.length;
  const articleTitle = document.getElementById('title');
  const titleFeedbackDiv = document.getElementById('titleFeedbackDiv');

  if(titleLen == 0 || titleLen > 100) {
    articleTitle.classList.remove('is-valid');
    articleTitle.classList.add('is-invalid');
    titleFeedbackDiv.style.visibility = 'visible';

    return false;
  } else {
    articleTitle.classList.remove('is-invalid');
    articleTitle.classList.add('is-valid');
    titleFeedbackDiv.style.visibility = 'hidden';

    return true;
  }
}

function validateText(text) {
  const textLen = getTextLength(text);
  const codeMirror = document.getElementsByClassName('CodeMirror')[0];
  const textFeedbackDiv = document.getElementById('textFeedbackDiv');

  if(textLen < 100 || textLen > 10000) {
    codeMirror.classList.remove('codemirror-valid');
    codeMirror.classList.add('codemirror-invalid');
    textFeedbackDiv.style.visibility = 'visible';

    return false;
  } else {
    codeMirror.classList.add('codemirror-valid');
    codeMirror.classList.remove('codemirror-invalid');
    textFeedbackDiv.style.visibility = 'hidden';

    return true;
  }
}

function validateTags(tags, n) {
  const tagsLen = tags.length;
  const articleTags = document.getElementById('articleTags');
  const tagFeedbackDiv = document.getElementById('tagFeedbackDiv');

  if(tagsLen == 0 || tagsLen > n) {
    articleTags.classList.remove('is-valid');
    articleTags.classList.add('is-invalid');
    tagFeedbackDiv.style.visibility = 'visible';

    tagFeedbackDiv.innerHTML = `Article needs between 1 and ${n} tags`;
    return false;
  } else {
    articleTags.classList.remove('is-invalid');
    articleTags.classList.add('is-valid');
    tagFeedbackDiv.style.visibility = 'hidden';

    return true;
  }
}