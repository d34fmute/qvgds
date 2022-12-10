
import type { TQuestion } from '@/types/TQuestion';
import { base } from './airtable.instance';

export const qustionsTable = base.table<TQuestion>('questions');

export const getQuestions = async () => {
  return await qustionsTable.select().all();
};

export const getQuestionsBySessionId = async (groupId: string) => {
    return await qustionsTable
      .select({ filterByFormula: `FIND("${groupId}", ARRAYJOIN(session, " "))` })
      .all();
  };