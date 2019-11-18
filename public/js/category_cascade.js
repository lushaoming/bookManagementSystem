function _getFirstCats() {
    var ret = {};
    var i = 0;
    for (var index in bookCategories) {
        ret[i] = {
            "id": bookCategories[index].id,
            "name": bookCategories[index].name
        }
        i++;
    }
    return ret;
}

function _getSecondCats(id) {
    var ret = {};
    var i = 0;
    var secondCats = bookCategories[id].child;
    for (var index in secondCats) {
        ret[i] = {
            "id": secondCats[index].id,
            "name": secondCats[index].name
        }
        i++;
    }
    return ret;
}

function _getThirdCats(firstId, secondId) {
    var ret = {};
    var i = 0;
    var thirdCats = bookCategories[firstId].child[secondId].child;
    for (var index in thirdCats) {
        ret[i] = {
            "id": thirdCats[index].id,
            "name": thirdCats[index].name
        }
        i++;
    }
    return ret;
}

function _getFourthCats(firstId, secondId, thirdId) {
    var ret = {};
    var i = 0;
    var fourthCats = bookCategories[firstId].child[secondId].child[thirdId].child;
    for (var index in fourthCats) {
        ret[i] = {
            "id": fourthCats[index].id,
            "name": fourthCats[index].name
        }
        i++;
    }
    return ret;
}