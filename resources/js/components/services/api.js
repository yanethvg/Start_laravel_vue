const API_URL = 'http://real_time_feedback.test/users';

export default {
    resource(context) {
        return context.$resource(API_URL + '{/id}');
    }
}
