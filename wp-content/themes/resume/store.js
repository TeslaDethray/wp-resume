import { configureStore } from '@reduxjs/toolkit';
import filterReducer from './features/filter/filter-slice';

export const store = configureStore({
  reducer: {
    filter: filterReducer,
  },
});
