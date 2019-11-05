import axios from 'axios';

export const getSchedules = async (date_entry, user_id) => {
    const url = `/api/schedules/${date_entry}/${user_id}`;
    const response = await axios.get(url);
    return response.data;
};
